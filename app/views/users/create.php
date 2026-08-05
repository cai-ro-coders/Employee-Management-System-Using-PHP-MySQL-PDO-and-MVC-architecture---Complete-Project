<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <strong>Add New User</strong>
                <a href="<?= url('users') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back</a>
            </div>
            <div class="card-body">
                <form method="post" action="<?= url('users/store') ?>">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">First Name</label><input name="first_name" class="form-control" value="<?= e(old('first_name')) ?>" required></div>
                        <div class="col-md-6"><label class="form-label">Last Name</label><input name="last_name" class="form-control" value="<?= e(old('last_name')) ?>" required></div>
                        <div class="col-md-6"><label class="form-label">Username</label><input name="username" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <select name="role_id" class="form-select" required>
                                <option value="">Select role</option>
                                <?php foreach ($roles as $r): ?><option value="<?= $r['id'] ?>"><?= e($r['name']) ?></option><?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label">Phone</label><input name="phone" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Password</label><input type="password" name="password" class="form-control" minlength="8" required></div>
                        <div class="col-12">
                            <button class="btn btn-primary"><i class="bi bi-check-lg"></i> Create User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>