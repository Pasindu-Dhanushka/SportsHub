<?php
namespace App\Services;

use App\Core\Database;
use App\Core\Auth;
use PDOException;

final class SportsHubService
{
    public function joinClub(int $clubId): void
    {
        $userId = Auth::id();
        $stmt = Database::connection()->prepare('SELECT id, status FROM memberships WHERE user_id=? AND club_id=? LIMIT 1');
        $stmt->execute([$userId, $clubId]);
        $existing = $stmt->fetch();
        if ($existing) {
            throw new \RuntimeException('You already have a membership request for this club.');
        }
        $stmt = Database::connection()->prepare('INSERT INTO memberships (user_id, club_id, status) VALUES (?, ?, "pending")');
        $stmt->execute([$userId, $clubId]);
    }

    public function registerTournament(int $tournamentId, string $teamName): void
    {
        $stmt = Database::connection()->prepare('SELECT * FROM tournaments WHERE id=? LIMIT 1');
        $stmt->execute([$tournamentId]);
        $tournament = $stmt->fetch();
        if (!$tournament || $tournament['status'] !== 'open') {
            throw new \RuntimeException('This tournament is not open for registration.');
        }
        if (strtotime($tournament['registration_deadline']) < strtotime(date('Y-m-d'))) {
            throw new \RuntimeException('The registration deadline has passed.');
        }
        try {
            $stmt = Database::connection()->prepare('INSERT INTO tournament_registrations (tournament_id, user_id, team_name, status) VALUES (?, ?, ?, "pending")');
            $stmt->execute([$tournamentId, Auth::id(), trim($teamName)]);
        } catch (PDOException) {
            throw new \RuntimeException('You are already registered for this tournament.');
        }
    }

    public function dashboardStats(): array
    {
        $db = Database::connection();
        if (Auth::isAdmin()) {
            return [
                'clubs' => (int) $db->query('SELECT COUNT(*) FROM clubs WHERE status="active"')->fetchColumn(),
                'members' => (int) $db->query('SELECT COUNT(*) FROM memberships WHERE status="approved"')->fetchColumn(),
                'pending' => (int) $db->query('SELECT COUNT(*) FROM memberships WHERE status="pending"')->fetchColumn(),
                'bookings' => (int) $db->query('SELECT COUNT(*) FROM bookings WHERE status="pending"')->fetchColumn(),
            ];
        }
        $userId = Auth::id();
        $stmt = $db->prepare('SELECT COUNT(*) FROM memberships WHERE user_id=? AND status="approved"'); $stmt->execute([$userId]); $clubs = (int) $stmt->fetchColumn();
        $stmt = $db->prepare('SELECT COUNT(*) FROM tournament_registrations WHERE user_id=?'); $stmt->execute([$userId]); $tournaments = (int) $stmt->fetchColumn();
        $stmt = $db->prepare('SELECT COALESCE(SUM(points),0) FROM participation WHERE user_id=?'); $stmt->execute([$userId]); $points = (int) $stmt->fetchColumn();
        $stmt = $db->prepare('SELECT COUNT(*) FROM bookings WHERE user_id=? AND status="pending"'); $stmt->execute([$userId]); $bookings = (int) $stmt->fetchColumn();
        return compact('clubs', 'tournaments', 'points', 'bookings');
    }
}
