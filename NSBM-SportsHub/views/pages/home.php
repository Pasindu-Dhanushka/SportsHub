<?php require __DIR__ . '/../partials/header.php'; ?>
<section class="hero-section section-pad">
    <div class="container hero-grid">
        <div class="hero-copy reveal">
            <div class="hero-kicker"><span class="pulse-dot"></span> NSBM Sports Community</div>
            <h1>Where campus<br><span class="gradient-text">competition lives.</span></h1>
            <p>Discover clubs, follow fixtures, enter tournaments, reserve facilities and track your sporting journey — all in one beautifully connected hub.</p>
            <div class="hero-actions">
                <a class="btn btn-primary btn-lg" href="<?= e(url('register')) ?>">Create student account <i class="bi bi-arrow-right"></i></a>
                <a class="btn btn-ghost btn-lg" href="#clubs">Explore clubs <i class="bi bi-chevron-down"></i></a>
            </div>
            <div class="hero-proof">
                <div class="avatar-stack"><span>BK</span><span>CR</span><span>VB</span><span>+</span></div>
                <div><strong><?= count($clubs) ?>+ active clubs</strong><small>Training, competing and growing together</small></div>
            </div>
        </div>

        <div class="hero-visual reveal delay-1">
            <div class="score-card glass-panel float-card">
                <div class="score-top"><span class="live-badge"><i></i> NEXT FIXTURE</span><span>SPORTSHUB</span></div>
                <?php $heroMatch = $nextMatches[0] ?? null; ?>
                <?php if ($heroMatch): ?>
                    <div class="versus-row">
                        <div class="team-badge nsbm">NS</div>
                        <div class="versus-copy"><small><?= e($heroMatch['competition']) ?></small><strong>VS</strong><span><?= e(format_date($heroMatch['match_date'], 'D · M d')) ?></span></div>
                        <div class="team-badge opponent"><?= e(substr($heroMatch['opponent'], 0, 2)) ?></div>
                    </div>
                    <div class="score-meta"><span><i class="bi bi-geo-alt-fill"></i><?= e($heroMatch['venue']) ?></span><span><i class="bi bi-clock-fill"></i><?= e(date('g:i A', strtotime($heroMatch['start_time']))) ?></span></div>
                <?php else: ?>
                    <div class="empty-mini">No upcoming fixture yet.</div>
                <?php endif; ?>
            </div>
            <div class="mini-stat-card glass-panel mini-one"><i class="bi bi-trophy-fill"></i><div><strong>Compete</strong><small>Campus tournaments</small></div></div>
            <div class="mini-stat-card glass-panel mini-two"><i class="bi bi-people-fill"></i><div><strong>Belong</strong><small>Find your team</small></div></div>
            <div class="court-grid" aria-hidden="true"><span></span><span></span><span></span><span></span></div>
        </div>
    </div>
</section>

<section class="metric-strip">
    <div class="container metric-grid reveal">
        <div><strong data-count="<?= $publicStats['clubs'] ?>">0</strong><span>Active sports clubs</span></div>
        <div><strong data-count="<?= $publicStats['sessions'] ?>">0</strong><span>Recent sessions</span></div>
        <div><strong data-count="<?= $publicStats['fixtures'] ?>">0</strong><span>Campus fixtures</span></div>
        <div><strong data-count="<?= $publicStats['students'] ?>">0</strong><span>Student athletes</span></div>
    </div>
</section>

<section class="section-pad" id="clubs">
    <div class="container">
        <div class="section-head reveal">
            <div><span class="eyebrow">Find your arena</span><h2>Popular sports clubs</h2><p>Join a community that matches your energy, skill and ambition.</p></div>
            <a class="text-link" href="<?= e(url('register')) ?>">View after sign in <i class="bi bi-arrow-up-right"></i></a>
        </div>
        <div class="club-grid">
            <?php foreach ($clubs as $i => $club): ?>
                <article class="club-card reveal" style="--delay: <?= $i * 60 ?>ms">
                    <div class="club-card-top"><span class="sport-icon"><i class="bi bi-trophy-fill"></i></span><span class="status-pill success">Active</span></div>
                    <span class="eyebrow"><?= e($club['sport']) ?></span>
                    <h3><?= e($club['name']) ?></h3>
                    <p><?= e(mb_strimwidth($club['description'], 0, 118, '…')) ?></p>
                    <div class="club-meta"><span><i class="bi bi-people-fill"></i><?= (int) $club['member_count'] ?> members</span><span><i class="bi bi-geo-alt-fill"></i><?= e($club['venue']) ?></span></div>
                    <div class="club-card-footer"><span><?= e($club['training_days']) ?></span><a href="<?= e(url('register')) ?>"><i class="bi bi-arrow-up-right"></i></a></div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-pad section-soft" id="fixtures">
    <div class="container split-section">
        <div class="section-copy reveal"><span class="eyebrow">Game day</span><h2>Never miss<br>a fixture.</h2><p>Schedules, opponents, venues and results stay together so every athlete knows what comes next.</p><a class="btn btn-secondary" href="<?= e(url('login')) ?>">Open fixtures <i class="bi bi-arrow-right"></i></a></div>
        <div class="fixture-stack reveal delay-1">
            <?php foreach ($nextMatches as $match): ?>
                <div class="fixture-card glass-panel">
                    <div class="fixture-date"><strong><?= e(date('d', strtotime($match['match_date']))) ?></strong><span><?= e(strtoupper(date('M', strtotime($match['match_date'])))) ?></span></div>
                    <div class="fixture-main"><span class="eyebrow"><?= e($match['sport']) ?> · <?= e($match['competition']) ?></span><strong><?= e($match['club_name']) ?> <span>vs</span> <?= e($match['opponent']) ?></strong><small><i class="bi bi-geo-alt"></i> <?= e($match['venue']) ?> · <?= e(date('g:i A', strtotime($match['start_time']))) ?></small></div>
                    <span class="status-pill warning">Scheduled</span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-pad" id="tournaments">
    <div class="container">
        <div class="section-head reveal"><div><span class="eyebrow">Raise the stakes</span><h2>Open tournaments</h2><p>Challenge yourself, represent your club and make the scoreboard remember you.</p></div></div>
        <div class="tournament-grid">
            <?php foreach ($tournaments as $i => $tournament): ?>
                <article class="tournament-card reveal" style="--delay: <?= $i * 70 ?>ms">
                    <div class="tournament-glow"></div><span class="status-pill success">Registration open</span>
                    <div class="tournament-icon"><i class="bi bi-award-fill"></i></div>
                    <span class="eyebrow"><?= e($tournament['sport']) ?></span><h3><?= e($tournament['title']) ?></h3>
                    <div class="tournament-info"><span><i class="bi bi-calendar3"></i><?= e(format_date($tournament['start_date'])) ?></span><span><i class="bi bi-geo-alt"></i><?= e($tournament['location']) ?></span></div>
                    <div class="deadline"><small>Registration deadline</small><strong><?= e(format_date($tournament['registration_deadline'])) ?></strong></div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta-section section-pad">
    <div class="container">
        <div class="cta-card reveal"><div class="cta-lines"></div><span class="eyebrow">Your next season starts here</span><h2>Ready to get in the game?</h2><p>Create your SportsHub account and connect with NSBM's sporting community.</p><a class="btn btn-light btn-lg" href="<?= e(url('register')) ?>">Join SportsHub <i class="bi bi-arrow-up-right"></i></a></div>
    </div>
</section>
<?php require __DIR__ . '/../partials/footer.php'; ?>
