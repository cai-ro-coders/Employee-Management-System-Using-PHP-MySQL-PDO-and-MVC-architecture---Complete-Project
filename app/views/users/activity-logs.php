<div class="d-flex justify-content-between align-items-center mb-3">
    <div><h5 class="fw-bold mb-0">Activity Logs</h5><small class="text-muted">Audit trail of system actions</small></div>
    <a href="<?= url('users') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Users</a>
</div>

<form class="row g-2 mb-3" method="get" action="<?= url('users/logs') ?>">
    <div class="col-md-4"><input type="text" name="q" class="form-control" placeholder="Search description/action" value="<?= e($search) ?>"></div>
    <div class="col-md-3">
        <select name="module" class="form-select">
            <option value="">All modules</option>
            <?php foreach (['auth','users','employees','departments','customers','roles','settings','profile'] as $m): ?>
                <option value="<?= $m ?>" <?= $module === $m ? 'selected' : '' ?>><?= e(ucfirst($m)) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2"><button class="btn btn-primary"><i class="bi bi-search"></i></button></div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead><tr><th>User</th><th>Action</th><th>Module</th><th>Description</th><th>IP</th><th>Time</th></tr></thead>
            <tbody>
            <?php foreach ($logs['items'] as $l): ?>
                <tr>
                    <td><?= e(($l['first_name'] ?? 'System') . ' ' . ($l['last_name'] ?? '')) ?></td>
                    <td><span class="badge bg-secondary"><?= e($l['action']) ?></span></td>
                    <td><?= e($l['module']) ?></td>
                    <td class="text-muted"><?= e($l['description']) ?></td>
                    <td class="text-muted"><?= e($l['ip_address']) ?></td>
                    <td><?= format_date($l['created_at'], 'M d, Y H:i') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php if ($logs['pages'] > 1): ?>
        <div class="card-footer bg-transparent">
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <?php for ($p = 1; $p <= $logs['pages']; $p++): ?>
                        <li class="page-item <?= $p == $logs['page'] ? 'active' : '' ?>">
                            <a class="page-link" href="<?= url('users/logs?page=' . $p . '&q=' . urlencode($search) . '&module=' . urlencode($module)) ?>"><?= $p ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
</div>