<div class="d-flex justify-content-between align-items-center mb-3">
    <div><h5 class="fw-bold mb-0">Settings</h5><small class="text-muted">Company & system configuration</small></div>
</div>

<?php
$tabs = [
    'company' => ['Company', 'bi bi-building'],
    'general' => ['General', 'bi bi-sliders'],
    'smtp'    => ['Email (SMTP)', 'bi bi-envelope'],
    'appearance' => ['Appearance', 'bi bi-palette'],
];
$tab = key($tabs);
?>
<ul class="nav nav-pills mb-3 gap-1">
    <?php foreach ($tabs as $key => [$label, $icon]): ?>
        <li class="nav-item"><button class="nav-link <?= isset($_GET['tab']) === false && $key === 'company' ? 'active' : (($_GET['tab'] ?? 'company') === $key ? 'active' : '') ?>" data-bs-toggle="pill" data-bs-target="#tab-<?= $key ?>"><i class="bi <?= $icon ?> me-1"></i><?= $label ?></button></li>
    <?php endforeach; ?>
</ul>

<form method="post" action="<?= url('settings/save') ?>">
<?= csrf_field() ?>
<div class="tab-content">
    <div class="tab-pane fade show active" id="tab-company">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Company Name</label><input name="company_name" class="form-control" value="<?= e($settings['company_name'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Company Email</label><input name="company_email" class="form-control" value="<?= e($settings['company_email'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Company Phone</label><input name="company_phone" class="form-control" value="<?= e($settings['company_phone'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Address</label><input name="company_address" class="form-control" value="<?= e($settings['company_address'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Currency Symbol</label><input name="currency_symbol" class="form-control" value="<?= e($settings['currency_symbol'] ?? '₱') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Currency</label><input name="currency" class="form-control" value="<?= e($settings['currency'] ?? 'PHP') ?>"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab-general">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Time Zone</label><select name="timezone" class="form-select">
                        <?php foreach (['Asia/Manila','UTC','Asia/Kolkata','Europe/London','America/New_York','America/Los_Angeles'] as $tz): ?>
                            <option value="<?= $tz ?>" <?= ($settings['timezone'] ?? 'Asia/Manila') === $tz ? 'selected' : '' ?>><?= $tz ?></option>
                        <?php endforeach; ?>
                    </select></div>
                    <div class="col-md-6"><label class="form-label">Language</label><select name="language" class="form-select">
                        <option value="English" <?= ($settings['language'] ?? 'English') === 'English' ? 'selected' : '' ?>>English</option>
                        <option value="Filipino" <?= ($settings['language'] ?? '') === 'Filipino' ? 'selected' : '' ?>>Filipino</option>
                    </select></div>
                    <div class="col-md-6"><label class="form-label">Date Format</label><input name="date_format" class="form-control" value="<?= e($settings['date_format'] ?? 'M d, Y') ?>"></div>
                    <div class="col-md-6"><label class="form-label">System Name</label><input name="system_name" class="form-control" value="<?= e($settings['system_name'] ?? '') ?>"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab-smtp">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">SMTP Host</label><input name="smtp_host" class="form-control" value="<?= e($settings['smtp_host'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">SMTP Port</label><input name="smtp_port" class="form-control" value="<?= e($settings['smtp_port'] ?? '587') ?>"></div>
                    <div class="col-md-6"><label class="form-label">SMTP Username</label><input name="smtp_username" class="form-control" value="<?= e($settings['smtp_username'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">SMTP Password</label><input type="password" name="smtp_password" class="form-control" value="<?= e($settings['smtp_password'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Encryption</label><select name="smtp_encryption" class="form-select">
                        <option value="tls" <?= ($settings['smtp_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' ?>>TLS</option>
                        <option value="ssl" <?= ($settings['smtp_encryption'] ?? '') === 'ssl' ? 'selected' : '' ?>>SSL</option>
                    </select></div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="tab-appearance">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Default Theme</label><select name="theme" class="form-select">
                        <option value="light" <?= ($settings['theme'] ?? 'light') === 'light' ? 'selected' : '' ?>>Light</option>
                        <option value="dark" <?= ($settings['theme'] ?? '') === 'dark' ? 'selected' : '' ?>>Dark</option>
                    </select></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3"><button class="btn btn-primary"><i class="bi bi-check-lg"></i> Save Settings</button></div>
</form>