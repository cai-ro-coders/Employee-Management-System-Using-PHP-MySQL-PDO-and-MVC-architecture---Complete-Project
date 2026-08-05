<div class="d-flex justify-content-between align-items-center mb-3">
    <div><h5 class="fw-bold mb-0">Login History</h5><small class="text-muted">All authentication attempts</small></div>
</div>

<form class="row g-2 mb-3" method="get" action="<?= url('users/login-history') ?>">
    <div class="col-md-4"><input type="text" name="q" class="form-control" placeholder="Search email / user agent" value="<?= e($search) ?>"></div>
    <div class="col-md-2"><button class="btn btn-primary"><i class="bi bi-search"></i></button></div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead><tr><th>User</th><th>IP Address</th><th>Status</th><th>Message</th><th>User Agent</th><th>Time</th></tr></thead>
            <tbody>
            <?php foreach ($logs['items'] as $l): ?>
                <tr>
                    <td><?= e($l['user_email'] ?? 'Anonymous') ?></td>
                    <td class="text-muted"><?= e($l['ip_address']) ?></td>
                    <td><?= status_badge($l['status']) ?></td>
                    <td class="text-muted"><?= e($l['message']) ?></td>
                    <td class="text-muted small"><?= e(substr($l['user_agent'], 0, 60)) ?></td>
                    <td><?= time_ago($l['login_at']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php if ($logs['pages'] > 1): ?>
        <div class="card-footer bg-transparent">
            <nav><ul class="pagination pagination-sm mb-0">
                <?php for ($p = 1; $p <= $logs['pages']; $p++): ?>
                    <li class="page-item <?= $p == $logs['page'] ? 'active' : '' ?>"><a class="page-link" href="<?= url('users/login-history?page=' . $p . '&q=' . urlencode($search)) ?>"><?= $p ?></a></li>
                <?php endfor; ?>
            </ul></nav>
        </div>
    <?php endif; ?>
</div>