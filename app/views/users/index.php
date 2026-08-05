<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold mb-0">Users</h5>
        <small class="text-muted">Manage system users and their access</small>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal"><i class="bi bi-plus-lg"></i> Add User</button>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="usersTable">
            <thead>
                <tr><th>User</th><th>Username</th><th>Role</th><th>Status</th><th>Last Login</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="<?= $u['avatar'] ? asset('uploads/' . $u['avatar']) : avatar(null, $u['first_name'] . ' ' . $u['last_name']) ?>" class="avatar-sm me-2" alt="">
                            <div>
                                <strong><?= e($u['first_name'] . ' ' . $u['last_name']) ?></strong>
                                <div class="small text-muted"><?= e($u['email']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td><?= e($u['username']) ?></td>
                    <td><span class="badge bg-primary-subtle text-primary"><?= e($u['role_name']) ?></span></td>
                    <td><?= status_badge($u['status']) ?></td>
                    <td class="text-muted"><?= $u['last_login'] ? time_ago($u['last_login']) : 'Never' ?></td>
                    <td class="text-end">
                        <a href="<?= url('users/edit/' . $u['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <?php if ($u['id'] !== \Auth::id()): ?>
                        <button type="button" class="btn btn-sm btn-outline-danger" data-confirm data-message="This user will be permanently deleted." data-url="<?= url('users/delete/' . $u['id']) ?>"><i class="bi bi-trash"></i></button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add/Edit User Modal -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="userForm">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">First Name</label><input name="first_name" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Last Name</label><input name="last_name" class="form-control" required></div>
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
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $scripts[] = <<<'JS'
<script>
$(function(){
    $('#usersTable').DataTable({ order: [[0,'asc']], pageLength: 10 });

    $('#userForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: EMS_BASE + '/users/store', method: 'POST', dataType: 'json',
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(r){ toast(r.message, 'success'); setTimeout(function(){ location.href = r.redirect; }, 900); },
            error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(x){ toast('Error', 'error'); } }
        });
    });
});
</script>
JS;
?>
