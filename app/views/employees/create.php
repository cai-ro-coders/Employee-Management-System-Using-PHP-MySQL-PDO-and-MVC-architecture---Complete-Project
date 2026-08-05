<div class="d-flex justify-content-between align-items-center mb-3">
    <div><h5 class="fw-bold mb-0">Add Employee</h5><small class="text-muted">Create user account and employment record</small></div>
    <a href="<?= url('employees') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="post" action="<?= url('employees/store') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <h6 class="text-primary"><i class="bi bi-person-lines-fill me-1"></i> Personal Information</h6>
            <hr>
            <div class="row g-3 mb-4">
                <div class="col-md-4"><label class="form-label">First Name</label><input name="first_name" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">Last Name</label><input name="last_name" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">Phone</label><input name="phone" class="form-control"></div>
                <div class="col-md-4"><label class="form-label">Department</label>
                    <select name="department_id" class="form-select" required>
                        <option value="">Select department</option>
                        <?php foreach ($departments as $d): ?><option value="<?= $d['id'] ?>"><?= e($d['name']) ?></option><?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4"><label class="form-label">Designation</label><input name="designation" class="form-control"></div>
                <div class="col-md-4">
                    <label class="form-label">Photo</label>
                    <div class="d-flex align-items-center gap-3">
                        <img id="avatarPreview" src="" alt="" class="rounded-circle d-none" style="width:54px;height:54px;object-fit:cover;background:var(--border)">
                        <input type="file" name="avatar" id="avatarInput" class="form-control form-control-sm" accept="image/*">
                    </div>
                    <small class="text-muted">JPG, PNG, GIF, WEBP up to 5MB</small>
                </div>
            </div>

            <h6 class="text-primary"><i class="bi bi-wallet2 me-1"></i> Employment Details</h6>
            <hr>
            <div class="row g-3 mb-3">
                <div class="col-md-4"><label class="form-label">Salary</label><input type="number" step="0.01" name="salary" class="form-control" min="0"></div>
                <div class="col-md-4"><label class="form-label">Joining Date</label><input type="date" name="joining_date" class="form-control" value="<?= date('Y-m-d') ?>"></div>
                <div class="col-md-4"><label class="form-label">Default Password</label><input type="text" name="password" class="form-control" value="password123"></div>
            </div>

            <button class="btn btn-primary"><i class="bi bi-check-lg"></i> Save Employee</button>
        </form>
    </div>
</div>

<?php $scripts[] = <<<'JS'
<script>
$(function(){
    $('#avatarInput').on('change', function(){
        var file = this.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function(e){
            $('#avatarPreview').attr('src', e.target.result).removeClass('d-none');
        };
        reader.readAsDataURL(file);
    });
});
</script>
JS;
?>