<?php
namespace App\Models;

use App\Core\Database;

final class Club
{
    public static function featured(int $limit = 6): array
    {
        $stmt = Database::connection()->prepare('SELECT c.*, COUNT(m.id) AS member_count FROM clubs c LEFT JOIN memberships m ON m.club_id=c.id AND m.status="approved" WHERE c.status="active" GROUP BY c.id ORDER BY member_count DESC, c.name LIMIT :limit');
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
