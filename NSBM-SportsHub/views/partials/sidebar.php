<?php
use App\Core\Auth;
$modules = require __DIR__ . '/../../config/modules.php';
?>
<aside class="sidebar" data-sidebar>
    <div class="sidebar-inner">
        <a class="brand sidebar-brand" href="<?= e(url('dashboard')) ?>">
            <span class="brand-mark"><i class="bi bi-lightning-charge-fill"></i></span>
            <span><strong>SportsHub</strong><small>NSBM Green University</small></span>
        </a>

        <nav class="sidebar-nav">
            <span class="nav-label">Overview</span>
            <a class="nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>" href="<?= e(url('dashboard')) ?>"><i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span></a>

            <span class="nav-label">Sports operations</span>
            <?php foreach ($modules as $key => $module): ?>
                <?php if (!in_array(Auth::role(), $module['roles'], true)) continue; ?>
                <a class="nav-link <?= $currentPage === 'module' && $currentModule === $key ? 'active' : '' ?>" href="<?= e(url('module', ['module' => $key])) ?>">
                    <i class="bi <?= e($module['icon']) ?>"></i><span><?= e($module['title']) ?></span>
                    <?php if ($key === 'memberships' && Auth::isAdmin()): ?><span class="nav-dot"></span><?php endif; ?>
                </a>
            <?php endforeach; ?>

            <?php if (Auth::isAdmin()): ?>
                <span class="nav-label">Insights</span>
                <a class="nav-link <?= $currentPage === 'reports' ? 'active' : '' ?>" href="<?= e(url('reports')) ?>"><i class="bi bi-pie-chart-fill"></i><span>Reports & Analytics</span></a>
            <?php endif; ?>
        </nav>

        <div class="sidebar-bottom">
            <a class="nav-link <?= $currentPage === 'profile' ? 'active' : '' ?>" href="<?= e(url('profile')) ?>"><i class="bi bi-person-circle"></i><span>My Profile</span></a>
            <form method="post" action="<?= e(url('logout')) ?>">
                <?= csrf_field() ?>
                <button class="nav-link nav-button" type="submit"><i class="bi bi-box-arrow-left"></i><span>Sign out</span></button>
            </form>
            <div class="sidebar-help glass-panel">
                <span class="help-icon"><i class="bi bi-stars"></i></span>
                <div><strong>Play your part.</strong><small>Stay active, show up, compete.</small></div>
            </div>
        </div>
    </div>
</aside>
<div class="sidebar-overlay" data-sidebar-overlay></div>
