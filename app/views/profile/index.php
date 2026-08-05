<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <div class="avatar-lg mx-auto mb-3" style="width:96px;height:96px;border-radius:50%;overflow:hidden;background:var(--brand);color:#fff;display:grid;place-items:center;font-size:34px;">
                    <img src="<?= $user['avatar'] ? asset('uploads/' . $user['avatar']) : '' ?>" alt="" class="w-100 h-100 object-fit-cover" onerror="this.style.display='none'">
                    <i class="bi bi-person-fill" style="<?= $user['avatar'] ? 'display:none' : '' ?>"></i>
                </div>
                <h5 class="fw-bold mb-1"><?= e($user['first_name'] . ' ' . $user['last_name']) ?></h5>
                <span class="badge bg-primary"><?= e($user['role_name']) ?></span>
                <div class="text-muted mt-1"><?= e($user['email']) ?></div>
                <div class="mt-3">
                    <form method="post" action="<?= url('profile/avatar') ?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="file" name="avatar" class="form-control form-control-sm mb-2" accept="image/*" required>
                        <button class="btn btn-sm btn-outline-primary w-100"><i class="bi bi-camera"></i> Update Avatar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-transparent"><strong>Account Info</strong></div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Username</span><strong><?= e($user['username']) ?></strong></li>
                <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Status</span><?= status_badge($user['status']) ?></li>
                <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Last Login</span><span><?= $user['last_login'] ? time_ago($user['last_login']) : 'Never' ?></span></li>
                <li class="list-group-item d-flex justify-content-between"><span class="text-muted">Member Since</span><span><?= format_date($user['created_at']) ?></span></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent"><strong>Personal Information</strong></div>
            <div class="card-body">
                <form method="post" action="<?= url('profile/update') ?>">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="<?= e($user['first_name']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="<?= e($user['last_name']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?= e($user['phone']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="<?= e($user['email']) ?>" disabled>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2"><?= e($user['address']) ?></textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary"><i class="bi bi-check-lg"></i> Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-transparent"><strong>Recent Login History</strong></div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead><tr><th>Date</th><th>IP Address</th><th>Status</th><th>Message</th></tr></thead>
                    <tbody>
                    <?php foreach ((new \App\Models\User())->recentLoginHistory(Auth::id(), 5) as $h): ?>
                        <tr>
                            <td><?= time_ago($h['login_at']) ?></td>
                            <td class="text-muted"><?= e($h['ip_address']) ?></td>
                            <td><?= status_badge($h['status']) ?></td>
                            <td class="text-muted"><?= e($h['message']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>