<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="page-heading reveal">
    <div><span class="eyebrow">Control center</span><h1>Good <?= date('H') < 12 ? 'morning' : (date('H') < 18 ? 'afternoon' : 'evening') ?>, <?= e(explode(' ', \App\Core\Auth::user()['name'])[0]) ?>.</h1><p>Here’s what is happening across NSBM sports today.</p></div>
    <a class="btn btn-primary" href="<?= e(url('module_form', ['module' => 'clubs'])) ?>"><i class="bi bi-plus-lg"></i> New club</a>
</div>

<div class="stat-grid reveal delay-1">
    <article class="stat-card accent-one"><div class="stat-icon"><i class="bi bi-shield-fill-check"></i></div><div><span>Active clubs</span><strong data-count="<?= $stats['clubs'] ?>">0</strong><small>Across campus</small></div><i class="bi bi-arrow-up-right stat-arrow"></i></article>
    <article class="stat-card accent-two"><div class="stat-icon"><i class="bi bi-people-fill"></i></div><div><span>Approved members</span><strong data-count="<?= $stats['members'] ?>">0</strong><small>Student athletes</small></div><i class="bi bi-arrow-up-right stat-arrow"></i></article>
    <article class="stat-card accent-three"><div class="stat-icon"><i class="bi bi-hourglass-split"></i></div><div><span>Pending memberships</span><strong data-count="<?= $stats['pending'] ?>">0</strong><small>Need review</small></div><i class="bi bi-arrow-up-right stat-arrow"></i></article>
    <article class="stat-card accent-four"><div class="stat-icon"><i class="bi bi-building-check"></i></div><div><span>Pending bookings</span><strong data-count="<?= $stats['bookings'] ?>">0</strong><small>Awaiting decision</small></div><i class="bi bi-arrow-up-right stat-arrow"></i></article>
</div>

<div class="dashboard-grid">
    <section class="panel span-7 reveal">
        <div class="panel-head"><div><span class="eyebrow">Membership queue</span><h2>Recent applications</h2></div><a class="text-link" href="<?= e(url('module', ['module' => 'memberships'])) ?>">View all <i class="bi bi-arrow-right"></i></a></div>
        <div class="compact-list">
            <?php foreach ($recentMemberships as $row): ?>
                <div class="compact-row"><span class="avatar small"><?= e(initials($row['student_name'])) ?></span><div class="grow"><strong><?= e($row['student_name']) ?></strong><small><?= e($row['student_id']) ?> · <?= e($row['club_name']) ?></small></div><span class="status-pill <?= e(status_class($row['status'])) ?>"><?= e(ucfirst($row['status'])) ?></span></div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="panel span-5 reveal delay-1">
        <div class="panel-head"><div><span class="eyebrow">Coming up</span><h2>Next fixtures</h2></div><a class="icon-btn tiny" href="<?= e(url('module', ['module' => 'matches'])) ?>"><i class="bi bi-arrow-up-right"></i></a></div>
        <div class="fixture-mini-list">
            <?php foreach ($upcomingMatches as $match): ?>
                <div class="fixture-mini"><div class="fixture-date"><strong><?= e(date('d', strtotime($match['match_date']))) ?></strong><span><?= e(strtoupper(date('M', strtotime($match['match_date'])))) ?></span></div><div class="grow"><strong><?= e($match['club_name']) ?> <span>vs</span> <?= e($match['opponent']) ?></strong><small><?= e($match['venue']) ?> · <?= e(date('g:i A', strtotime($match['start_time']))) ?></small></div></div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="panel span-12 reveal">
        <div class="panel-head"><div><span class="eyebrow">Operations</span><h2>Latest booking requests</h2></div><a class="text-link" href="<?= e(url('module', ['module' => 'bookings'])) ?>">Manage bookings <i class="bi bi-arrow-right"></i></a></div>
        <div class="table-wrap"><table class="data-table"><thead><tr><th>Student</th><th>Type</th><th>Resource</th><th>Date</th><th>Status</th></tr></thead><tbody>
            <?php foreach ($recentBookings as $booking): ?><tr><td><strong><?= e($booking['student_name']) ?></strong></td><td><?= e(ucfirst($booking['booking_type'])) ?></td><td><?= e($booking['item_name']) ?></td><td><?= e(format_date($booking['booking_date'])) ?></td><td><span class="status-pill <?= e(status_class($booking['status'])) ?>"><?= e(ucfirst($booking['status'])) ?></span></td></tr><?php endforeach; ?>
        </tbody></table></div>
    </section>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
