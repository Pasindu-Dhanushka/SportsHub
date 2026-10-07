<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="page-heading reveal">
    <div><span class="eyebrow">Your sports journey</span><h1>Ready for your next move, <?= e(explode(' ', \App\Core\Auth::user()['name'])[0]) ?>?</h1><p>Everything you need to train, compete and stay involved.</p></div>
    <a class="btn btn-primary" href="<?= e(url('module', ['module' => 'clubs'])) ?>"><i class="bi bi-compass-fill"></i> Explore clubs</a>
</div>

<div class="stat-grid reveal delay-1">
    <article class="stat-card accent-one"><div class="stat-icon"><i class="bi bi-shield-check"></i></div><div><span>My clubs</span><strong data-count="<?= $stats['clubs'] ?>">0</strong><small>Approved memberships</small></div></article>
    <article class="stat-card accent-two"><div class="stat-icon"><i class="bi bi-trophy-fill"></i></div><div><span>Tournaments</span><strong data-count="<?= $stats['tournaments'] ?>">0</strong><small>Registrations</small></div></article>
    <article class="stat-card accent-three"><div class="stat-icon"><i class="bi bi-graph-up-arrow"></i></div><div><span>Performance points</span><strong data-count="<?= $stats['points'] ?>">0</strong><small>From activity history</small></div></article>
    <article class="stat-card accent-four"><div class="stat-icon"><i class="bi bi-hourglass-split"></i></div><div><span>Pending bookings</span><strong data-count="<?= $stats['bookings'] ?>">0</strong><small>Awaiting approval</small></div></article>
</div>

<div class="dashboard-grid">
    <section class="panel span-7 reveal">
        <div class="panel-head"><div><span class="eyebrow">My teams</span><h2>Club memberships</h2></div><a class="text-link" href="<?= e(url('module', ['module' => 'memberships'])) ?>">View history <i class="bi bi-arrow-right"></i></a></div>
        <div class="club-membership-grid">
            <?php if (!$memberships): ?><div class="empty-state"><i class="bi bi-compass"></i><strong>No clubs yet</strong><p>Explore active clubs and send your first membership request.</p></div><?php endif; ?>
            <?php foreach ($memberships as $membership): ?>
                <article class="membership-card"><span class="sport-icon small"><i class="bi bi-shield-fill"></i></span><div class="grow"><strong><?= e($membership['club_name']) ?></strong><small><?= e($membership['sport']) ?> · <?= e($membership['training_days']) ?></small></div><span class="status-pill <?= e(status_class($membership['status'])) ?>"><?= e(ucfirst($membership['status'])) ?></span></article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="panel span-5 reveal delay-1">
        <div class="panel-head"><div><span class="eyebrow">Next challenge</span><h2>Open tournaments</h2></div><a class="icon-btn tiny" href="<?= e(url('module', ['module' => 'tournaments'])) ?>"><i class="bi bi-arrow-up-right"></i></a></div>
        <div class="tournament-mini-list">
            <?php foreach ($openTournaments as $tournament): ?><div class="tournament-mini"><span class="tournament-mini-icon"><i class="bi bi-award-fill"></i></span><div class="grow"><strong><?= e($tournament['title']) ?></strong><small><?= e($tournament['sport']) ?> · deadline <?= e(format_date($tournament['registration_deadline'], 'M d')) ?></small></div><span class="status-pill success">Open</span></div><?php endforeach; ?>
        </div>
    </section>

    <section class="panel span-6 reveal">
        <div class="panel-head"><div><span class="eyebrow">Game calendar</span><h2>Upcoming fixtures</h2></div><a class="text-link" href="<?= e(url('module', ['module' => 'matches'])) ?>">All fixtures</a></div>
        <div class="fixture-mini-list">
            <?php foreach ($upcomingMatches as $match): ?><div class="fixture-mini"><div class="fixture-date"><strong><?= e(date('d', strtotime($match['match_date']))) ?></strong><span><?= e(strtoupper(date('M', strtotime($match['match_date'])))) ?></span></div><div class="grow"><strong><?= e($match['club_name']) ?> <span>vs</span> <?= e($match['opponent']) ?></strong><small><?= e($match['venue']) ?> · <?= e(date('g:i A', strtotime($match['start_time']))) ?></small></div></div><?php endforeach; ?>
        </div>
    </section>

    <section class="panel span-6 reveal delay-1">
        <div class="panel-head"><div><span class="eyebrow">Momentum</span><h2>Recent participation</h2></div><a class="text-link" href="<?= e(url('module', ['module' => 'participation'])) ?>">Full history</a></div>
        <div class="timeline-list">
            <?php foreach ($participation as $item): ?><div class="timeline-row"><span class="timeline-dot"></span><div class="grow"><strong><?= e($item['event_name']) ?></strong><small><?= e($item['club_name']) ?> · <?= e(format_date($item['event_date'], 'M d, Y')) ?></small></div><span class="points-badge">+<?= (int) $item['points'] ?> pts</span></div><?php endforeach; ?>
        </div>
    </section>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
