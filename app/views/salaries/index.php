<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div><h5 class="fw-bold mb-0">Salary Structure</h5><small class="text-muted">Configure employee salary components</small></div>
    <?php if ($canEdit): ?>
        <button class="btn btn-primary" id="addSalaryBtn" data-bs-toggle="modal" data-bs-target="#salaryModal"><i class="bi bi-plus-lg"></i> Add Structure</button>
    <?php endif; ?>
</div>

<div class="row g-2 mb-3">
    <div class="col-md-4"><input type="text" id="salarySearch" class="form-control" placeholder="Search by name or employee code..."></div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="salariesTable">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Department</th>
                    <th class="text-end">Basic</th>
                    <th class="text-end">HRA</th>
                    <th class="text-end">Medical</th>
                    <th class="text-end">Other</th>
                    <th class="text-end">Allowances</th>
                    <th class="text-end">PF</th>
                    <th class="text-end">Tax</th>
                    <th class="text-end">Net</th>
                    <?php if ($canEdit): ?><th class="text-end">Actions</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($salaries as $s):
                    $allow = $s['basic_salary'] + $s['house_rent_allowance'] + $s['medical_allowance'] + $s['other_allowances'];
                    $pf = $s['basic_salary'] * $s['pf_deduction_rate'] / 100;
                    $net = $allow - $pf - $s['tax_deduction'];
                ?>
                    <tr>
                        <td>
                            <strong><?= e($s['first_name'] . ' ' . $s['last_name']) ?></strong>
                            <div><small class="text-muted"><?= e($s['employee_code']) ?></small></div>
                        </td>
                        <td><?= e($s['department_name']) ?></td>
                        <td class="text-end"><?= money($s['basic_salary']) ?></td>
                        <td class="text-end"><?= money($s['house_rent_allowance']) ?></td>
                        <td class="text-end"><?= money($s['medical_allowance']) ?></td>
                        <td class="text-end"><?= money($s['other_allowances']) ?></td>
                        <td class="text-end text-success"><?= money($allow) ?></td>
                        <td class="text-end text-danger"><?= money($pf) ?> <small class="text-muted">(<?= (float) $s['pf_deduction_rate'] ?>%)</small></td>
                        <td class="text-end text-danger"><?= money($s['tax_deduction']) ?></td>
                        <td class="text-end fw-semibold"><?= money($net) ?></td>
                        <?php if ($canEdit): ?>
                        <td class="text-end text-nowrap">
                            <button class="btn btn-sm btn-outline-primary" data-edit
                                data-id="<?= $s['id'] ?>"
                                data-employee-id="<?= $s['employee_id'] ?>"
                                data-employee-name="<?= e($s['first_name'] . ' ' . $s['last_name']) ?>"
                                data-basic="<?= $s['basic_salary'] ?>"
                                data-hra="<?= $s['house_rent_allowance'] ?>"
                                data-med="<?= $s['medical_allowance'] ?>"
                                data-other="<?= $s['other_allowances'] ?>"
                                data-pf="<?= $s['pf_deduction_rate'] ?>"
                                data-tax="<?= $s['tax_deduction'] ?>"
                                title="Edit"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger" data-remove data-id="<?= $s['id'] ?>" title="Delete"><i class="bi bi-trash"></i></button>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<span id="salaryEmptyMsg" class="d-none">No salary structures configured yet.</span>

<!-- Modal -->
<div class="modal fade" id="salaryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="salaryForm">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="salaryId">
                <div class="modal-header">
                    <h5 class="modal-title" id="salaryModalTitle">Add Salary Structure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Employee</label>
                        <select name="employee_id" id="salaryEmployee" class="form-select" required>
                            <option value="">Select employee</option>
                            <?php foreach ($employees as $emp): ?>
                                <option value="<?= $emp['id'] ?>" data-structure="<?= isset($structureIds[$emp['id']]) ? 1 : 0 ?>">
                                    <?= e($emp['first_name'] . ' ' . $emp['last_name']) ?> (<?= e($emp['employee_code']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Employees who already have a structure are hidden when adding.</small>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Basic Salary</label>
                            <input type="number" step="0.01" min="0" name="basic_salary" id="salaryBasic" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">House Rent Allowance</label>
                            <input type="number" step="0.01" min="0" name="house_rent_allowance" id="salaryHra" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Medical Allowance</label>
                            <input type="number" step="0.01" min="0" name="medical_allowance" id="salaryMed" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Other Allowances</label>
                            <input type="number" step="0.01" min="0" name="other_allowances" id="salaryOther" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">PF Deduction Rate (%)</label>
                            <input type="number" step="0.01" min="0" max="100" name="pf_deduction_rate" id="salaryPf" class="form-control" value="12">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tax Deduction</label>
                            <input type="number" step="0.01" min="0" name="tax_deduction" id="salaryTax" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Structure</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $scripts[] = <<<'JS'
<script>
$(function(){
    const csrf = $('meta[name="csrf-token"]').attr('content');
    let modalMode = 'create';

    const table = $('#salariesTable').DataTable({
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        order: [],
        dom: '<"d-flex flex-wrap justify-content-between align-items-center mb-2"l>rt<"d-flex flex-wrap justify-content-between align-items-center mt-2"ip>',
        language: { emptyTable: $('#salaryEmptyMsg').text() }
    });

    $('#salarySearch').on('input', function(){ table.search(this.value).draw(); });

    $('#addSalaryBtn').on('click', function(){
        modalMode = 'create';
        $('#salaryId').val('');
    });

    $('#salaryModal').on('show.bs.modal', function(){
        if (modalMode === 'create') {
            $('#salaryForm')[0].reset();
            $('#salaryModalTitle').text('Add Salary Structure');
            $('#salaryEmployee').prop('disabled', false);
            $('#salaryEmployee option').prop('disabled', false).filter('[data-structure="1"]').prop('disabled', true);
        }
    });

    $(document).on('click', '[data-edit]', function(){
        modalMode = 'edit';
        var el = $(this);
        $('#salaryId').val(el.data('id'));
        var empId = el.data('employee-id');
        $('#salaryEmployee option').prop('disabled', false);
        if (!$('#salaryEmployee option[value="' + empId + '"]').length) {
            $('#salaryEmployee').append('<option value="' + empId + '">' + el.data('employee-name') + '</option>');
        }
        $('#salaryEmployee').val(empId).prop('disabled', true);
        $('#salaryBasic').val(el.data('basic'));
        $('#salaryHra').val(el.data('hra'));
        $('#salaryMed').val(el.data('med'));
        $('#salaryOther').val(el.data('other'));
        $('#salaryPf').val(el.data('pf'));
        $('#salaryTax').val(el.data('tax'));
        $('#salaryModalTitle').text('Edit Salary Structure');
        new bootstrap.Modal(document.getElementById('salaryModal')).show();
    });

    $('#salaryForm').on('submit', function(e){
        e.preventDefault();
        const id = $('#salaryId').val();
        const url = id ? (EMS_BASE + '/salaries/update/' + id) : (EMS_BASE + '/salaries/store');
        $.ajax({
            url: url, method: 'POST', dataType: 'json', data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': csrf },
            success: function(r){ toast(r.message, 'success'); bootstrap.Modal.getInstance(document.getElementById('salaryModal')).hide(); setTimeout(function(){ location.reload(); }, 800); },
            error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(x){ toast('Error', 'error'); } }
        });
    });

    $(document).on('click', '[data-remove]', function(){
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete salary structure?', icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc3545', confirmButtonText: 'Delete'
        }).then(function(result){
            if (result.isConfirmed) {
                $.ajax({
                    url: EMS_BASE + '/salaries/delete/' + id, method: 'POST', dataType: 'json', data: { _token: csrf },
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
