<?php
namespace App\Core;

final class View
{
    public static function render(string $name, array $data = []): void
    {
        $path = __DIR__ . '/../../views/' . $name . '.php';
        if (!is_file($path)) {
            throw new \RuntimeException("View not found: {$name}");
        }
        extract($data, EXTR_SKIP);
        require $path;
    }
}
