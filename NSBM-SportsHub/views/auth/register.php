<?php require __DIR__ . '/../partials/header.php'; ?>
<section class="auth-shell section-pad">
    <div class="auth-card auth-card-wide glass-panel reveal">
        <a class="auth-back" href="<?= e(url('home')) ?>"><i class="bi bi-arrow-left"></i> Back to home</a>
        <div class="auth-icon"><i class="bi bi-person-plus-fill"></i></div>
        <span class="eyebrow">Student registration</span><h1>Build your sporting profile</h1><p>One account for clubs, tournaments, bookings and your activity history.</p>
        <form method="post" action="<?= e(url('register')) ?>" class="form-grid" novalidate>
            <?= csrf_field() ?>
            <label class="field field-span-2"><span>Full name</span><div class="input-shell"><i class="bi bi-person"></i><input type="text" name="name" placeholder="Your full name" required></div></label>
            <label class="field"><span>NSBM email</span><div class="input-shell"><i class="bi bi-envelope"></i><input type="email" name="email" placeholder="you@nsbm.ac.lk" required></div></label>
            <label class="field"><span>Student ID</span><div class="input-shell"><i class="bi bi-person-vcard"></i><input type="text" name="student_id" placeholder="e.g. 2623456" required></div></label>
            <label class="field field-span-2"><span>Faculty / school</span><div class="input-shell"><i class="bi bi-buildings"></i><input type="text" name="faculty" placeholder="Faculty of Computing" required></div></label>
            <label class="field"><span>Password</span><div class="input-shell"><i class="bi bi-lock"></i><input type="password" name="password" placeholder="Minimum 8 characters" required></div></label>
            <label class="field"><span>Confirm password</span><div class="input-shell"><i class="bi bi-shield-check"></i><input type="password" name="password_confirmation" placeholder="Repeat password" required></div></label>
            <div class="field-span-2"><button class="btn btn-primary btn-block btn-lg" type="submit">Create account <i class="bi bi-arrow-up-right"></i></button></div>
        </form>
        <p class="auth-switch">Already registered? <a href="<?= e(url('login')) ?>">Sign in</a></p>
    </div>
</section>
<?php require __DIR__ . '/../partials/footer.php'; ?>
