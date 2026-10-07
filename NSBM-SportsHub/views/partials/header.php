<?php
use App\Core\Auth;
$fullTitle = isset($title) && $title !== 'Home' ? e($title) . ' · ' . e(app_config('app_name')) : e(app_config('app_name'));
$flashes = pull_flashes();
$currentPage = $_GET['page'] ?? 'home';
$currentModule = $_GET['module'] ?? '';
?>
<!doctype html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="NSBM SportsHub — Sports club management, fixtures, tournaments and participation.">
    <title><?= $fullTitle ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= e(asset('css/app.css')) ?>">
</head>
<body>
<div class="ambient-bg" aria-hidden="true">
    <span class="orb orb-one"></span><span class="orb orb-two"></span><span class="orb orb-three"></span>
</div>

<?php if (Auth::check()): ?>
<div class="app-shell">
    <?php require __DIR__ . '/sidebar.php'; ?>
    <main class="app-main">
        <header class="topbar glass-panel">
            <button class="icon-btn mobile-menu-btn" type="button" data-sidebar-toggle aria-label="Open navigation"><i class="bi bi-list"></i></button>
            <div class="topbar-copy">
                <span class="eyebrow"><?= Auth::isAdmin() ? 'Sports administration' : 'Student portal' ?></span>
                <strong><?= e($title ?? 'SportsHub') ?></strong>
            </div>
            <div class="topbar-actions">
                <button class="icon-btn" type="button" data-theme-toggle aria-label="Toggle theme"><i class="bi bi-sun-fill"></i></button>
                <a class="profile-chip" href="<?= e(url('profile')) ?>">
                    <span class="avatar"><?= e(initials(Auth::user()['name'])) ?></span>
                    <span class="profile-chip-copy"><strong><?= e(Auth::user()['name']) ?></strong><small><?= e(ucfirst(Auth::role())) ?></small></span>
                </a>
            </div>
        </header>
        <section class="page-content">
<?php else: ?>
<header class="public-nav-wrap">
    <nav class="public-nav glass-panel">
        <a class="brand" href="<?= e(url('home')) ?>">
            <span class="brand-mark"><i class="bi bi-lightning-charge-fill"></i></span>
            <span><strong>SportsHub</strong><small>NSBM Green University</small></span>
        </a>
        <div class="public-links">
            <a href="<?= e(url('home')) ?>#clubs">Clubs</a>
            <a href="<?= e(url('home')) ?>#fixtures">Fixtures</a>
            <a href="<?= e(url('home')) ?>#tournaments">Tournaments</a>
        </div>
        <div class="nav-actions">
            <button class="icon-btn" type="button" data-theme-toggle aria-label="Toggle theme"><i class="bi bi-sun-fill"></i></button>
            <a class="btn btn-ghost" href="<?= e(url('login')) ?>">Sign in</a>
            <a class="btn btn-primary" href="<?= e(url('register')) ?>">Join SportsHub <i class="bi bi-arrow-up-right"></i></a>
        </div>
    </nav>
</header>
<main>
<?php endif; ?>

<?php if ($flashes): ?>
<div class="toast-stack" aria-live="polite">
    <?php foreach ($flashes as $flash): ?>
        <div class="toast <?= e($flash['type']) ?>" data-toast>
            <i class="bi <?= $flash['type'] === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill' ?>"></i>
            <span><?= e($flash['message']) ?></span>
            <button type="button" data-toast-close aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
