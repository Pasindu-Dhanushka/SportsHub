<?php require __DIR__ . '/../partials/header.php'; ?>
<section class="auth-shell section-pad">
    <div class="auth-card glass-panel reveal">
        <a class="auth-back" href="<?= e(url('home')) ?>"><i class="bi bi-arrow-left"></i> Back to home</a>
        <div class="auth-icon"><i class="bi bi-lightning-charge-fill"></i></div>
        <span class="eyebrow">Welcome back</span><h1>Sign in to SportsHub</h1><p>Manage your clubs, fixtures, bookings and participation.</p>
        <form method="post" action="<?= e(url('login')) ?>" class="form-stack" novalidate>
            <?= csrf_field() ?>
            <label class="field"><span>Email address</span><div class="input-shell"><i class="bi bi-envelope"></i><input type="email" name="email" placeholder="you@nsbm.ac.lk" autocomplete="email" required></div></label>
            <label class="field"><span>Password</span><div class="input-shell"><i class="bi bi-lock"></i><input type="password" name="password" placeholder="Enter your password" autocomplete="current-password" required><button class="password-toggle" type="button" data-password-toggle aria-label="Show password"><i class="bi bi-eye"></i></button></div></label>
            <button class="btn btn-primary btn-block btn-lg" type="submit">Sign in <i class="bi bi-arrow-right"></i></button>
        </form>
        <div class="auth-demo"><span>Demo accounts</span><div><code>admin@sportshub.lk</code><small>Admin@123</small></div><div><code>student@sportshub.lk</code><small>Student@123</small></div></div>
        <p class="auth-switch">New to SportsHub? <a href="<?= e(url('register')) ?>">Create an account</a></p>
    </div>
</section>
<?php require __DIR__ . '/../partials/footer.php'; ?>
