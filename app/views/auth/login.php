<div class="text-center mb-3">
    <h5 class="fw-bold mb-0">Welcome Back</h5>
    <small class="text-muted">Sign in to your account</small>
</div>

<form method="post" action="<?= url('login') ?>" autocomplete="off">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label class="form-label">Email or Username</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" name="identifier" class="form-control" value="<?= e(old('identifier')) ?>" placeholder="admin@ems.local" required autofocus>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
            <button type="button" class="btn btn-outline-secondary" data-toggle-password="#password">
                <i class="bi bi-eye"></i>
            </button>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" value="on">
            <label class="form-check-label small" for="remember">Remember me</label>
        </div>
        <a href="<?= url('forgot-password') ?>" class="small text-decoration-none">Forgot password?</a>
    </div>
    <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-box-arrow-in-right"></i> Sign In
    </button>
</form>

<p class="text-center text-muted small mt-3 mb-0">
    Demo: <strong>admin</strong> / <strong>password123</strong>
</p>