<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Database;
use PDO;

final class CrudController
{
    private array $modules;

    public function __construct()
    {
        $this->modules = require __DIR__ . '/../../config/modules.php';
    }

    private function module(string $key): array
    {
        if (!isset($this->modules[$key])) {
            http_response_code(404);
            view('pages/404', ['title' => 'Module not found']);
            exit;
        }
        $module = $this->modules[$key];
        Auth::requireRole($module['roles']);
        return $module;
    }

    public function index(string $key): void
    {
        $module = $this->module($key);
        $db = Database::connection();
        $search = trim($_GET['q'] ?? '');
        $status = trim($_GET['status'] ?? '');
        $where = [];
        $params = [];

        if (!Auth::isAdmin() && !empty($module['scope_field'])) {
            $where[] = $module['scope_field'] . ' = :current_user';
            $params['current_user'] = Auth::id();
        }
        if ($search !== '' && !empty($module['search'])) {
            $parts = [];
            foreach ($module['search'] as $i => $column) {
                $parts[] = "$column LIKE :q$i";
                $params["q$i"] = "%{$search}%";
            }
            $where[] = '(' . implode(' OR ', $parts) . ')';
        }
        if ($status !== '' && isset($module['fields']['status'])) {
            $where[] = ($module['alias'] ?? $module['table']) . '.status = :status';
            $params['status'] = $status;
        }

        $sql = 'SELECT ' . $module['select'] . ' FROM ' . $module['from'];
        if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
        $sql .= ' ORDER BY ' . ($module['order'] ?? '1 DESC');
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        view('modules/list', [
            'title' => $module['title'], 'moduleKey' => $key, 'module' => $module,
            'rows' => $rows, 'search' => $search, 'statusFilter' => $status,
        ]);
    }

    public function form(string $key, ?int $id = null): void
    {
        $module = $this->module($key);
        $action = $id ? 'edit' : 'create';
        $allowed = $id ? $module['edit_roles'] : $module['create_roles'];
        Auth::requireRole($allowed);

        $record = null;
        if ($id) {
            $stmt = Database::connection()->prepare('SELECT * FROM ' . $module['table'] . ' WHERE id=? LIMIT 1');
            $stmt->execute([$id]);
            $record = $stmt->fetch();
            if (!$record) {
                flash('error', $module['singular'] . ' not found.');
                redirect('module', ['module' => $key]);
            }
            $this->assertOwnerWhenStudent($module, $record);
        }

        $relationOptions = [];
        foreach ($module['fields'] as $name => $field) {
            if (in_array($field['type'], ['relation', 'owner_relation'], true) && !empty($field['query'])) {
                $relationOptions[$name] = Database::connection()->query($field['query'])->fetchAll();
            }
        }

        view('modules/form', [
            'title' => ($id ? 'Edit ' : 'Create ') . $module['singular'],
            'moduleKey' => $key, 'module' => $module, 'record' => $record,
            'relationOptions' => $relationOptions, 'mode' => $action,
        ]);
    }

    public function save(string $key, ?int $id = null): void
    {
        Csrf::verify();
        $module = $this->module($key);
        $allowed = $id ? $module['edit_roles'] : $module['create_roles'];
        Auth::requireRole($allowed);

        if ($id) {
            $stmt = Database::connection()->prepare('SELECT * FROM ' . $module['table'] . ' WHERE id=? LIMIT 1');
            $stmt->execute([$id]);
            $existing = $stmt->fetch();
            if (!$existing) {
                flash('error', 'Record not found.');
                redirect('module', ['module' => $key]);
            }
            $this->assertOwnerWhenStudent($module, $existing);
        }

        $data = [];
        foreach ($module['fields'] as $name => $field) {
            $type = $field['type'];
            if ($type === 'owner_relation' && !Auth::isAdmin()) {
                $data[$name] = Auth::id();
                continue;
            }
            if (str_starts_with($type, 'admin_') && !Auth::isAdmin()) {
                if (!$id) $data[$name] = $field['default'] ?? null;
                continue;
            }
            $value = $_POST[$name] ?? null;
            $value = is_string($value) ? trim($value) : $value;
            if (($field['required'] ?? false) && ($value === null || $value === '')) {
                flash('error', $field['label'] . ' is required.');
                redirect('module_form', ['module' => $key] + ($id ? ['id' => $id] : []));
            }
            if ($value === '') $value = null;
            $data[$name] = $value;
        }

        if ($key === 'bookings' && !Auth::isAdmin() && $id) {
            $data['status'] = 'pending';
            unset($data['admin_note']);
        }

        $db = Database::connection();
        if ($id) {
            $sets = [];
            foreach (array_keys($data) as $column) $sets[] = "$column=:$column";
            $data['id'] = $id;
            $stmt = $db->prepare('UPDATE ' . $module['table'] . ' SET ' . implode(', ', $sets) . ' WHERE id=:id');
            $stmt->execute($data);
            flash('success', $module['singular'] . ' updated successfully.');
        } else {
            $columns = array_keys($data);
            $placeholders = array_map(fn($c) => ':' . $c, $columns);
            $stmt = $db->prepare('INSERT INTO ' . $module['table'] . ' (' . implode(',', $columns) . ') VALUES (' . implode(',', $placeholders) . ')');
            $stmt->execute($data);
            flash('success', $module['singular'] . ' created successfully.');
        }
        redirect('module', ['module' => $key]);
    }

    public function delete(string $key, int $id): void
    {
        Csrf::verify();
        $module = $this->module($key);
        Auth::requireRole($module['delete_roles']);
        $stmt = Database::connection()->prepare('SELECT * FROM ' . $module['table'] . ' WHERE id=? LIMIT 1');
        $stmt->execute([$id]);
        $record = $stmt->fetch();
        if ($record) {
            $this->assertOwnerWhenStudent($module, $record);
            try {
                $stmt = Database::connection()->prepare('DELETE FROM ' . $module['table'] . ' WHERE id=?');
                $stmt->execute([$id]);
                flash('success', $module['singular'] . ' deleted successfully.');
            } catch (\Throwable) {
                flash('error', 'This record cannot be deleted because other records depend on it.');
            }
        }
        redirect('module', ['module' => $key]);
    }

    private function assertOwnerWhenStudent(array $module, array $record): void
    {
        if (!Auth::isAdmin() && !empty($module['owner_field'])) {
            if ((int) ($record[$module['owner_field']] ?? 0) !== Auth::id()) {
                http_response_code(403);
                view('pages/403', ['title' => 'Access denied']);
                exit;
            }
        }
    }
}
