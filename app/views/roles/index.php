<div class="d-flex justify-content-between align-items-center mb-3">
    <div><h5 class="fw-bold mb-0">Roles</h5><small class="text-muted">System roles and assigned users</small></div>
    <a href="<?= url('roles/permissions') ?>" class="btn btn-primary"><i class="bi bi-key"></i> Manage Permissions</a>
</div>

<div class="row g-3">
    <?php foreach ($roles as $role): ?>
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary-subtle text-primary me-3"><i class="bi bi-person-badge"></i></div>
                            <div>
                                <h6 class="mb-0 fw-bold"><?= e($role['name']) ?></h6>
                                <small class="text-muted"><?= $role['user_count'] ?> user(s)</small>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted small mt-3 mb-2"><?= e($role['description'] ?? 'No description') ?></p>
                    <a href="<?= url('roles/permissions') ?>" class="btn btn-sm btn-outline-primary">Edit Permissions</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>