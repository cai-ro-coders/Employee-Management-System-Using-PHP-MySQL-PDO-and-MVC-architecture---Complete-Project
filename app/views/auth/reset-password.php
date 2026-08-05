<div class="text-center mb-3">
    <h5 class="fw-bold mb-0">Set New Password</h5>
    <small class="text-muted">Choose a strong new password</small>
</div>

<form method="post" action="<?= url('reset-password') ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="token" value="<?= e($token) ?>">
    <div class="mb-3">
        <label class="form-label">New Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control" minlength="8" placeholder="Min 8 characters" required>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
        </div>
    </div>
    <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-check-lg"></i> Reset Password
    </button>
</form>

<p class="text-center mt-3 mb-0">
    <a href="<?= url('login') ?>" class="small text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Sign In</a>
</p>