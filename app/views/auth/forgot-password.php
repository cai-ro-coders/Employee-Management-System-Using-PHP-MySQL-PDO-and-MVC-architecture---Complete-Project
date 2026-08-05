<div class="text-center mb-3">
    <h5 class="fw-bold mb-0">Forgot Password</h5>
    <small class="text-muted">Enter your email to receive a reset link</small>
</div>

<form method="post" action="<?= url('forgot-password') ?>">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
        </div>
    </div>
    <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-send"></i> Send Reset Link
    </button>
</form>

<p class="text-center mt-3 mb-0">
    <a href="<?= url('login') ?>" class="small text-decoration-none"><i class="bi bi-arrow-left"></i> Back to Sign In</a>
</p>