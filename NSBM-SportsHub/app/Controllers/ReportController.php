<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Database;

final class ReportController
{
    public function index(): void
    {
        Auth::requireRole(['admin']);
        $db = Database::connection();
        $clubPerformance = $db->query('SELECT c.name, c.sport, COUNT(DISTINCT CASE WHEN m.status="approved" THEN m.id END) AS members, COUNT(DISTINCT p.id) AS activities, COALESCE(SUM(p.points),0) AS points FROM clubs c LEFT JOIN memberships m ON m.club_id=c.id LEFT JOIN participation p ON p.club_id=c.id GROUP BY c.id ORDER BY points DESC, members DESC')->fetchAll();
        $bookingBreakdown = $db->query('SELECT status, COUNT(*) total FROM bookings GROUP BY status')->fetchAll();
        $resultBreakdown = $db->query('SELECT result, COUNT(*) total FROM match_results GROUP BY result')->fetchAll();
        $monthlyParticipation = $db->query('SELECT DATE_FORMAT(event_date, "%Y-%m") month, COUNT(*) total FROM participation WHERE event_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) GROUP BY month ORDER BY month')->fetchAll();
        view('pages/reports', compact('clubPerformance', 'bookingBreakdown', 'resultBreakdown', 'monthlyParticipation') + ['title' => 'Reports & Analytics']);
    }
}
