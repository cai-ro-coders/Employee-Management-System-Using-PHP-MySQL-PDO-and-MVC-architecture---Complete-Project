<?php /* Auth layout - minimal centered card */ ?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title><?= e($title ?? 'Authentication') ?> - <?= e(setting('system_name', 'EMS')) ?></title>
    <link rel="stylesheet" href="<?= asset('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
</head>
<body class="auth-body">
    <div class="auth-wrapper">
        <div class="mb-4 text-center">
            <div class="auth-logo mb-2">
                <i class="bi bi-shield-lock"></i>
            </div>
            <h4 class="fw-bold mb-0"><?= e(setting('system_name', 'Employee Management System')) ?></h4>
            <small class="text-muted"><?= e(setting('tagline', 'Secure Admin Console')) ?></small>
        </div>

        <div class="card border-0 shadow auth-card">
            <div class="card-body p-4">
                <?php flash(); ?>
                <?= $content ?>
            </div>
        </div>
        <p class="text-center text-muted mt-4 small">&copy; <?= date('Y') ?> <?= e(setting('company_name', 'EMS')) ?></p>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?= asset('js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>