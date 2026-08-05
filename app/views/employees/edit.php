<div class="d-flex justify-content-between align-items-center mb-3">
    <div><h5 class="fw-bold mb-0">Edit Employee</h5><small class="text-muted">Update employment and bank details</small></div>
    <a href="<?= url('employees') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<form method="post" action="<?= url('employees/update/' . $employee['id']) ?>" enctype="multipart/form-data">
<?= csrf_field() ?>
<div class="row g-3">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent"><strong><i class="bi bi-person-lines-fill me-1"></i> Personal & Employment</strong></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">First Name</label><input name="first_name" class="form-control" value="<?= e($employee['first_name']) ?>" required></div>
                    <div class="col-md-6"><label class="form-label">Last Name</label><input name="last_name" class="form-control" value="<?= e($employee['last_name']) ?>" required></div>
                    <div class="col-md-6"><label class="form-label">Email</label><input class="form-control" value="<?= e($employee['email']) ?>" disabled></div>
                    <div class="col-md-6"><label class="form-label">Phone</label><input name="phone" class="form-control" value="<?= e($employee['phone']) ?>"></div>
                    <div class="col-md-6">
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-select">
                            <?php foreach ($departments as $d): ?>
                                <option value="<?= $d['id'] ?>" <?= $d['id'] == $employee['department_id'] ? 'selected' : '' ?>><?= e($d['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6"><label class="form-label">Designation</label><input name="designation" class="form-control" value="<?= e($employee['designation']) ?>"></div>
                    <div class="col-md-6"><label class="form-label">Salary</label><input type="number" step="0.01" name="salary" class="form-control" value="<?= $employee['salary'] ?>"></div>
                    <div class="col-md-6"><label class="form-label">Joining Date</label><input type="date" name="joining_date" class="form-control" value="<?= $employee['joining_date'] ?>"></div>
                    <div class="col-12">
                        <label class="form-label">Photo</label>
                        <div class="d-flex align-items-center gap-3">
                            <img id="avatarPreview" src="<?= $employee['avatar'] ? asset('uploads/' . $employee['avatar']) : '' ?>" alt="" class="rounded-circle <?= $employee['avatar'] ? '' : 'd-none' ?>" style="width:54px;height:54px;object-fit:cover;background:var(--border)">
                            <div class="flex-grow-1">
                                <input type="file" name="avatar" id="avatarInput" class="form-control form-control-sm" accept="image/*">
                                <small class="text-muted">JPG, PNG, GIF, WEBP up to 5MB. Leave empty to keep current photo.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent"><strong><i class="bi bi-credit-card me-1"></i>Bank & Payment Info</strong></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Bank Name</label><input name="bank_name" class="form-control" value="<?= e($bank['bank_name'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Branch</label><input name="branch_name" class="form-control" value="<?= e($bank['branch_name'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Account Number</label><input name="account_number" class="form-control" value="<?= e($bank['account_number'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Account Title</label><input name="account_title" class="form-control" value="<?= e($bank['account_title'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">IFSC / SWIFT</label><input name="ifsc_swift_code" class="form-control" value="<?= e($bank['ifsc_swift_code'] ?? '') ?>"></div>
                    <div class="col-md-6"><label class="form-label">Tax ID / PAN</label><input name="tax_id_pan" class="form-control" value="<?= e($bank['tax_id_pan'] ?? '') ?>"></div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary mt-3 w-100"><i class="bi bi-check-lg"></i> Save Changes</button>
    </div>
</div>
</form>

<div class="card border-0 shadow-sm mt-3">
    <div class="card-header bg-transparent"><strong><i class="bi bi-folder2-open me-1"></i>Documents</strong></div>
    <div class="card-body">
        <form method="post" action="<?= url('employees/storeDocument/' . $employee['id']) ?>" enctype="multipart/form-data" class="row g-2 align-items-end mb-3">
            <?= csrf_field() ?>
            <div class="col-md-5">
                <label class="form-label mb-1">Document Title</label>
                <input name="document_title" class="form-control form-control-sm" placeholder="e.g. Employment Contract" required>
            </div>
            <div class="col-md-4">
                <label class="form-label mb-1">File</label>
                <input type="file" name="document_file" class="form-control form-control-sm" required>
            </div>
            <div class="col-md-3">
                <button class="btn btn-sm btn-primary w-100"><i class="bi bi-upload"></i> Upload</button>
            </div>
        </form>
        <?php if (empty($documents)): ?>
            <div class="text-muted small">No documents uploaded.</div>
        <?php else: ?>
            <div class="row g-2">
                <?php foreach ($documents as $doc): ?>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center border rounded p-2">
                            <i class="bi bi-file-earmark-text fs-4 me-2 text-primary"></i>
                            <a href="<?= asset('uploads/' . $doc['document_file']) ?>" target="_blank" class="flex-grow-1 text-decoration-none text-truncate">
                                <strong class="d-block text-body text-truncate"><?= e($doc['document_title']) ?></strong>
                                <small class="text-muted"><?= e($doc['file_type']) ?> · <?= time_ago($doc['uploaded_at']) ?></small>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-doc-del ms-2" data-id="<?= $doc['id'] ?>" title="Delete"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $scripts[] = <<<'JS'
<script>
$(function(){
    const csrf = $('meta[name="csrf-token"]').attr('content');

    $('#avatarInput').on('change', function(){
        var file = this.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function(e){
            $('#avatarPreview').attr('src', e.target.result).removeClass('d-none');
        };
        reader.readAsDataURL(file);
    });

    $(document).on('click', '.btn-doc-del', function(){
        var id = $(this).data('id');
        var btn = $(this);
        Swal.fire({
            title: 'Delete document?', icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc3545', confirmButtonText: 'Delete'
        }).then(function(result){
            if (result.isConfirmed) {
                $.ajax({
                    url: EMS_BASE + '/employees/deleteDocument/' + id, method: 'POST', dataType: 'json', data: { _token: csrf },
                    headers: { 'X-CSRF-TOKEN': csrf },
                    success: function(r){ toast(r.message, 'success'); btn.closest('.col-md-6').fadeOut(200, function(){ $(this).remove(); }); },
                    error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(e){ toast('Error', 'error'); } }
                });
            }
        });
    });
});
</script>
JS;
?>