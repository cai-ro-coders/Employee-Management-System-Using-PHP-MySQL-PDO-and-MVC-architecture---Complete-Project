<div class="d-flex justify-content-between align-items-center mb-3">
    <div><h5 class="fw-bold mb-0">Departments</h5><small class="text-muted">Organization departments and headcount</small></div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deptModal" data-mode="create"><i class="bi bi-plus-lg"></i> Add Department</button>
</div>

<div class="row g-3">
    <?php foreach ($departments as $d): ?>
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary-subtle text-primary fs-6"><?= e($d['code']) ?></span>
                            <h6 class="mb-0 fw-bold"><?= e($d['name']) ?></h6>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-icon btn-sm" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item" data-edit data-id="<?= $d['id'] ?>" data-name="<?= e($d['name']) ?>" data-code="<?= e($d['code']) ?>" data-status="<?= e($d['status']) ?>"><i class="bi bi-pencil me-2"></i>Edit</button>
                                <button class="dropdown-item text-danger" data-remove data-id="<?= $d['id'] ?>"><i class="bi bi-trash me-2"></i>Delete</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between text-muted small">
                        <span>Employees</span>
                        <strong><?= $d['employee_count'] ?></strong>
                    </div>
                    <div class="d-flex justify-content-between text-muted small mt-1">
                        <span>Status</span><?= status_badge($d['status']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="deptModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deptForm">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="deptId">
                <div class="modal-header">
                    <h5 class="modal-title" id="deptModalTitle">Add Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Department Name</label>
                        <input type="text" name="name" id="deptName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Code</label>
                        <input type="text" name="code" id="deptCode" class="form-control" required placeholder="e.g. ENG">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="deptStatus" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Department</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $scripts[] = <<<'JS'
<script>
$(function(){
    const csrf = $('meta[name="csrf-token"]').attr('content');

    $('[data-adds]').on('click', function(){
        $('#deptId').val(''); $('#deptName').val(''); $('#deptCode').val(''); $('#deptStatus').val('active');
        $('#deptModalTitle').text('Add Department');
    });

    $(document).on('click', '[data-edit]', function(){
        var el = $(this);
        $('#deptId').val(el.data('id'));
        $('#deptName').val(el.data('name'));
        $('#deptCode').val(el.data('code'));
        $('#deptStatus').val(el.data('status'));
        $('#deptModalTitle').text('Edit Department');
        new bootstrap.Modal(document.getElementById('deptModal')).show();
    });

    $('#deptForm').on('submit', function(e){
        e.preventDefault();
        const id = $('#deptId').val();
        const url = id ? (EMS_BASE + '/departments/update/' + id) : (EMS_BASE + '/departments/store');
        $.ajax({
            url: url, method: 'POST', dataType: 'json', data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': csrf },
            success: function(r){ toast(r.message, 'success'); setTimeout(function(){ location.reload(); }, 800); },
            error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(x){ toast('Error', 'error'); } }
        });
    });

    $(document).on('click', '[data-remove]', function(){
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete department?', icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc3545', confirmButtonText: 'Delete'
        }).then(function(result){
            if (result.isConfirmed) {
                $.ajax({
                    url: EMS_BASE + '/departments/delete/' + id, method: 'POST', dataType: 'json', data: { _token: csrf },
                    headers: { 'X-CSRF-TOKEN': csrf },
                    success: function(r){ toast(r.message, 'success'); setTimeout(function(){ location.reload(); }, 800); },
                    error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(e){ toast('Error', 'error'); } }
                });
            }
        });
    });
});
</script>
JS;
?>