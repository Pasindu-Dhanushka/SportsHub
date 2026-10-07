<?php
require __DIR__ . '/app/bootstrap.php';

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\CrudController;
use App\Controllers\ActionController;
use App\Controllers\ProfileController;
use App\Controllers\ReportController;

$page = $_GET['page'] ?? 'home';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

try {
    switch ($page) {
        case 'home':
            (new HomeController())->index();
            break;
        case 'login':
            $method === 'POST' ? (new AuthController())->login() : (new AuthController())->loginForm();
            break;
        case 'register':
            $method === 'POST' ? (new AuthController())->register() : (new AuthController())->registerForm();
            break;
        case 'logout':
            if ($method !== 'POST') redirect('home');
            (new AuthController())->logout();
            break;
        case 'dashboard':
            (new DashboardController())->index();
            break;
        case 'module':
            (new CrudController())->index((string) ($_GET['module'] ?? 'clubs'));
            break;
        case 'module_form':
            $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
            (new CrudController())->form((string) ($_GET['module'] ?? ''), $id);
            break;
        case 'module_save':
            if ($method !== 'POST') redirect('home');
            $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
            (new CrudController())->save((string) ($_GET['module'] ?? ''), $id);
            break;
        case 'module_delete':
            if ($method !== 'POST') redirect('home');
            (new CrudController())->delete((string) ($_GET['module'] ?? ''), (int) ($_GET['id'] ?? 0));
            break;
        case 'join_club':
            if ($method !== 'POST') redirect('home');
            (new ActionController())->joinClub();
            break;
        case 'register_tournament':
            if ($method !== 'POST') redirect('home');
            (new ActionController())->registerTournament();
            break;
        case 'profile':
            $method === 'POST' ? (new ProfileController())->update() : (new ProfileController())->index();
            break;
        case 'profile_password':
            if ($method !== 'POST') redirect('profile');
            (new ProfileController())->password();
            break;
        case 'reports':
            (new ReportController())->index();
            break;
        default:
            http_response_code(404);
            view('pages/404', ['title' => 'Page not found']);
    }
} catch (Throwable $e) {
    if (app_config('debug')) throw $e;
    http_response_code(500);
    view('pages/500', ['title' => 'Something went wrong']);
}
