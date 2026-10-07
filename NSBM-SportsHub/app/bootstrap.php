<?php
session_start();

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) return;
    $relative = substr($class, strlen($prefix));
    $path = __DIR__ . '/' . str_replace('\\', '/', $relative) . '.php';
    if (is_file($path)) require $path;
});

require __DIR__ . '/helpers.php';

date_default_timezone_set((string) app_config('timezone'));

if (app_config('debug')) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}
