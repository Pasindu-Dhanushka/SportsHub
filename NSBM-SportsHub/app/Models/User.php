<?php
namespace App\Models;

use App\Core\Database;
use PDO;

final class User
{
    public static function findByEmail(string $email): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $data): int
    {
        $sql = 'INSERT INTO users (name, email, password, student_id, faculty, role, status) VALUES (:name, :email, :password, :student_id, :faculty, "student", "active")';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($data);
        return (int) Database::connection()->lastInsertId();
    }

    public static function updateProfile(int $id, array $data): void
    {
        $stmt = Database::connection()->prepare('UPDATE users SET name=:name, student_id=:student_id, faculty=:faculty WHERE id=:id');
        $stmt->execute($data + ['id' => $id]);
    }

    public static function changePassword(int $id, string $hash): void
    {
        $stmt = Database::connection()->prepare('UPDATE users SET password=? WHERE id=?');
        $stmt->execute([$hash, $id]);
    }
}
