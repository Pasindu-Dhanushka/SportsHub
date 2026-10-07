<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Services\SportsHubService;

final class ActionController
{
    public function joinClub(): void
    {
        Auth::requireRole(['student']);
        Csrf::verify();
        try {
            (new SportsHubService())->joinClub((int) ($_POST['club_id'] ?? 0));
            flash('success', 'Membership request submitted. The sports admin will review it.');
        } catch (\Throwable $e) {
            flash('error', $e->getMessage());
        }
        redirect('module', ['module' => 'clubs']);
    }

    public function registerTournament(): void
    {
        Auth::requireRole(['student']);
        Csrf::verify();
        try {
            (new SportsHubService())->registerTournament((int) ($_POST['tournament_id'] ?? 0), (string) ($_POST['team_name'] ?? ''));
            flash('success', 'Tournament registration submitted successfully.');
        } catch (\Throwable $e) {
            flash('error', $e->getMessage());
        }
        redirect('module', ['module' => 'tournaments']);
    }
}
