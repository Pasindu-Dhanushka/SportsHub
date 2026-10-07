<?php
use App\Core\View;
use App\Core\Csrf;

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function app_config(?string $key = null): mixed
{
    static $config;
    $config ??= require __DIR__ . '/../config/config.php';
    return $key === null ? $config : ($config[$key] ?? null);
}

function base_url(): string
{
    $configured = rtrim((string) app_config('base_url'), '/');
    if ($configured !== '') return $configured;
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
    $dir = rtrim(dirname($script), '/');
    return $dir === '/' ? '' : $dir;
}

function url(string $page = 'home', array $params = []): string
{
    $query = http_build_query(array_merge(['page' => $page], $params));
    return base_url() . '/index.php?' . $query;
}

function asset(string $path): string
{
    return base_url() . '/assets/' . ltrim($path, '/');
}

function redirect(string $page, array $params = []): never
{
    header('Location: ' . url($page, $params));
    exit;
}

function view(string $name, array $data = []): void
{
    View::render($name, $data);
}

function csrf_field(): string
{
    return Csrf::field();
}

function flash(string $type, string $message): void
{
    $_SESSION['_flash'][] = ['type' => $type, 'message' => $message];
}

function pull_flashes(): array
{
    $flashes = $_SESSION['_flash'] ?? [];
    unset($_SESSION['_flash']);
    return $flashes;
}

function status_class(?string $status): string
{
    return match (strtolower((string) $status)) {
        'active', 'approved', 'completed', 'open', 'won' => 'success',
        'pending', 'scheduled', 'upcoming', 'draw' => 'warning',
        'rejected', 'cancelled', 'inactive', 'lost' => 'danger',
        default => 'neutral',
    };
}

function format_date(?string $date, string $format = 'M d, Y'): string
{
    if (!$date) return '—';
    return date($format, strtotime($date));
}

function initials(string $name): string
{
    $parts = preg_split('/\s+/', trim($name));
    return strtoupper(substr($parts[0] ?? 'U', 0, 1) . substr($parts[1] ?? '', 0, 1));
}
