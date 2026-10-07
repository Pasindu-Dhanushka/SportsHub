<?php
namespace App\Controllers;

use App\Core\Database;
use App\Models\Club;

final class HomeController
{
    public function index(): void
    {
        $db = Database::connection();
        $clubs = Club::featured(6);
        $nextMatches = $db->query('SELECT sm.*, c.name AS club_name, c.sport FROM sports_matches sm JOIN clubs c ON c.id=sm.club_id WHERE sm.status="scheduled" AND sm.match_date >= CURDATE() ORDER BY sm.match_date, sm.start_time LIMIT 3')->fetchAll();
        $tournaments = $db->query('SELECT * FROM tournaments WHERE status="open" AND registration_deadline >= CURDATE() ORDER BY start_date LIMIT 3')->fetchAll();
        $publicStats = [
            'clubs' => (int) $db->query('SELECT COUNT(*) FROM clubs WHERE status="active"')->fetchColumn(),
            'sessions' => (int) $db->query('SELECT COUNT(*) FROM training_sessions WHERE session_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)')->fetchColumn(),
            'fixtures' => (int) $db->query('SELECT COUNT(*) FROM sports_matches')->fetchColumn(),
            'students' => (int) $db->query('SELECT COUNT(*) FROM users WHERE role="student" AND status="active"')->fetchColumn(),
        ];
        view('pages/home', compact('clubs', 'nextMatches', 'tournaments', 'publicStats') + ['title' => 'Home']);
    }
}
