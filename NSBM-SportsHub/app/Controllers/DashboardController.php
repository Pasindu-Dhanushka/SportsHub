<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Database;
use App\Services\SportsHubService;

final class DashboardController
{
    public function index(): void
    {
        Auth::requireLogin();
        $db = Database::connection();
        $service = new SportsHubService();
        $stats = $service->dashboardStats();

        if (Auth::isAdmin()) {
            $recentMemberships = $db->query('SELECT m.*, u.name AS student_name, u.student_id, c.name AS club_name FROM memberships m JOIN users u ON u.id=m.user_id JOIN clubs c ON c.id=m.club_id ORDER BY m.created_at DESC LIMIT 6')->fetchAll();
            $upcomingMatches = $db->query('SELECT sm.*, c.name AS club_name FROM sports_matches sm JOIN clubs c ON c.id=sm.club_id WHERE sm.status="scheduled" ORDER BY sm.match_date, sm.start_time LIMIT 5')->fetchAll();
            $recentBookings = $db->query('SELECT b.*, u.name AS student_name FROM bookings b JOIN users u ON u.id=b.user_id ORDER BY b.created_at DESC LIMIT 5')->fetchAll();
            view('dashboard/admin', compact('stats', 'recentMemberships', 'upcomingMatches', 'recentBookings') + ['title' => 'Admin Dashboard']);
            return;
        }

        $userId = Auth::id();
        $stmt = $db->prepare('SELECT m.*, c.name AS club_name, c.sport, c.training_days FROM memberships m JOIN clubs c ON c.id=m.club_id WHERE m.user_id=? ORDER BY m.created_at DESC');
        $stmt->execute([$userId]);
        $memberships = $stmt->fetchAll();

        $stmt = $db->prepare('SELECT p.*, c.name AS club_name FROM participation p JOIN clubs c ON c.id=p.club_id WHERE p.user_id=? ORDER BY p.event_date DESC LIMIT 6');
        $stmt->execute([$userId]);
        $participation = $stmt->fetchAll();

        $upcomingMatches = $db->query('SELECT sm.*, c.name AS club_name FROM sports_matches sm JOIN clubs c ON c.id=sm.club_id WHERE sm.status="scheduled" AND sm.match_date >= CURDATE() ORDER BY sm.match_date, sm.start_time LIMIT 5')->fetchAll();
        $openTournaments = $db->query('SELECT * FROM tournaments WHERE status="open" AND registration_deadline >= CURDATE() ORDER BY registration_deadline LIMIT 4')->fetchAll();

        view('dashboard/student', compact('stats', 'memberships', 'participation', 'upcomingMatches', 'openTournaments') + ['title' => 'Student Dashboard']);
    }
}
