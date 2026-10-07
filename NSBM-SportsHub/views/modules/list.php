<?php
use App\Core\Auth;
require __DIR__ . '/../partials/header.php';
$canCreate = in_array(Auth::role(), $module['create_roles'], true);
$canEdit = in_array(Auth::role(), $module['edit_roles'], true);
$canDelete = in_array(Auth::role(), $module['delete_roles'], true);
$statusOptions = $module['fields']['status']['options'] ?? [];
?>
<div class="page-heading reveal">
    <div><span class="eyebrow">SportsHub module</span><h1><?= e($module['title']) ?></h1><p><?= e($module['description']) ?></p></div>
    <?php if ($canCreate): ?><a class="btn btn-primary" href="<?= e(url('module_form', ['module' => $moduleKey])) ?>"><i class="bi bi-plus-lg"></i> Add <?= e($module['singular']) ?></a><?php endif; ?>
</div>

<section class="panel reveal delay-1">
    <div class="table-toolbar">
        <form class="filter-form" method="get" action="index.php">
            <input type="hidden" name="page" value="module"><input type="hidden" name="module" value="<?= e($moduleKey) ?>">
            <label class="search-box"><i class="bi bi-search"></i><input type="search" name="q" value="<?= e($search) ?>" placeholder="Search <?= e(strtolower($module['title'])) ?>..."></label>
            <?php if ($statusOptions): ?>
                <select class="select-control" name="status" onchange="this.form.submit()"><option value="">All statuses</option><?php foreach ($statusOptions as $value => $label): ?><option value="<?= e($value) ?>" <?= $statusFilter === $value ? 'selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?></select>
            <?php endif; ?>
            <button class="btn btn-ghost btn-sm" type="submit"><i class="bi bi-funnel"></i> Filter</button>
            <?php if ($search || $statusFilter): ?><a class="btn btn-ghost btn-sm" href="<?= e(url('module', ['module' => $moduleKey])) ?>">Clear</a><?php endif; ?>
        </form>
        <span class="result-count"><strong><?= count($rows) ?></strong> records</span>
    </div>

    <?php if (!$rows): ?>
        <div class="empty-state large"><i class="bi <?= e($module['icon']) ?>"></i><strong>No records found</strong><p>Try adjusting your filters<?php if ($canCreate): ?> or create the first <?= e(strtolower($module['singular'])) ?><?php endif; ?>.</p></div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><?php foreach ($module['list_columns'] as $label): ?><th><?= e($label) ?></th><?php endforeach; ?><th class="actions-col">Actions</th></tr></thead>
                <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <?php foreach ($module['list_columns'] as $key => $label): ?>
                            <td data-label="<?= e($label) ?>">
                                <?php $value = $row[$key] ?? null; ?>
                                <?php if ($key === 'status' || $key === 'result'): ?>
                                    <span class="status-pill <?= e(status_class((string) $value)) ?>"><?= e(ucfirst((string) $value)) ?></span>
                                <?php elseif (str_contains($key, 'date') || str_contains($key, '_at')): ?>
                                    <?= e(format_date($value)) ?>
                                <?php elseif (str_contains($key, 'time') && $value): ?>
                                    <?= e(date('g:i A', strtotime($value))) ?>
                                <?php elseif ($key === 'points'): ?>
                                    <span class="points-badge">+<?= (int) $value ?> pts</span>
                                <?php elseif (in_array($key, ['name','title','student_name','club_name'], true)): ?>
                                    <strong><?= e($value) ?></strong>
                                <?php else: ?><?= e($value ?? '—') ?><?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                        <td class="row-actions">
                            <?php if (!Auth::isAdmin() && $moduleKey === 'clubs'): ?>
                                <form method="post" action="<?= e(url('join_club')) ?>" class="inline-form"><?= csrf_field() ?><input type="hidden" name="club_id" value="<?= (int) $row['id'] ?>"><button class="btn btn-primary btn-sm" type="submit"><i class="bi bi-person-plus-fill"></i> Join</button></form>
                            <?php elseif (!Auth::isAdmin() && $moduleKey === 'tournaments' && $row['status'] === 'open'): ?>
                                <button class="btn btn-primary btn-sm" type="button" data-tournament-open data-id="<?= (int) $row['id'] ?>" data-name="<?= e($row['title']) ?>"><i class="bi bi-ticket-perforated-fill"></i> Register</button>
                            <?php else: ?>
                                <?php if ($canEdit): ?><a class="icon-btn tiny" href="<?= e(url('module_form', ['module' => $moduleKey, 'id' => $row['id']])) ?>" title="Edit"><i class="bi bi-pencil-square"></i></a><?php endif; ?>
                                <?php if ($canDelete): ?><form class="inline-form" method="post" action="<?= e(url('module_delete', ['module' => $moduleKey, 'id' => $row['id']])) ?>" data-confirm="Delete this record? This action cannot be undone."><?= csrf_field() ?><button class="icon-btn tiny danger" type="submit" title="Delete"><i class="bi bi-trash3"></i></button></form><?php endif; ?>
                                <?php if (!$canEdit && !$canDelete): ?><span class="muted">View only</span><?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<?php if (!Auth::isAdmin() && $moduleKey === 'tournaments'): ?>
<dialog class="modal-dialog" data-tournament-dialog>
    <form method="post" action="<?= e(url('register_tournament')) ?>" class="modal-card">
        <?= csrf_field() ?><input type="hidden" name="tournament_id" data-tournament-id>
        <button type="button" class="modal-close icon-btn" data-tournament-close><i class="bi bi-x-lg"></i></button>
        <span class="modal-icon"><i class="bi bi-trophy-fill"></i></span><span class="eyebrow">Tournament entry</span><h2 data-tournament-name>Register</h2><p>Submit your entry. Admin approval may be required before participation.</p>
        <label class="field"><span>Team / entry name <small>(optional)</small></span><div class="input-shell"><i class="bi bi-people"></i><input type="text" name="team_name" placeholder="e.g. Green Titans"></div></label>
        <button class="btn btn-primary btn-block" type="submit">Submit registration <i class="bi bi-arrow-right"></i></button>
    </form>
</dialog>
<?php endif; ?>
<?php require __DIR__ . '/../partials/footer.php'; ?>
