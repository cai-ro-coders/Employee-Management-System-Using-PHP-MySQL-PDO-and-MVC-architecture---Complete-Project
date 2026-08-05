<?php $monthNames = [1 => 'January','February','March','April','May','June','July','August','September','October','November','December']; ?>
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-0">Generate Payslips</h5>
        <small class="text-muted"><?= e($monthNames[$month]) ?> <?= $year ?> &middot; generate and manage monthly payslips</small>
    </div>
    <?php if ($canEdit): ?>
        <form class="row g-2 align-items-center" id="psFilter">
            <div class="col-auto">
                <select name="month" id="psMonth" class="form-select form-select-sm">
                    <?php foreach ($monthNames as $m => $label): ?>
                        <option value="<?= $m ?>" <?= $m === $month ? 'selected' : '' ?>><?= e($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <input type="number" name="year" id="psYear" class="form-control form-control-sm" style="width:110px" min="2000" max="2100" value="<?= $year ?>">
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-sm btn-primary" id="psGenerate"><i class="bi bi-file-earmark-plus"></i> Generate</button>
            </div>
        </form>
    <?php endif; ?>
</div>

<!-- Stats -->
<div class="row g-3 mb-3">
    <div class="col-6 col-md-3"><div class="card border-0 shadow-sm"><div class="card-body text-center"><div class="fs-4 fw-bold text-primary"><?= $stats['total'] ?></div><small class="text-muted">Payslips</small></div></div></div>
    <div class="col-6 col-md-3"><div class="card border-0 shadow-sm"><div class="card-body text-center"><div class="fs-4 fw-bold text-success"><?= money($stats['net_total']) ?></div><small class="text-muted">Net Total</small></div></div></div>
    <div class="col-6 col-md-3"><div class="card border-0 shadow-sm"><div class="card-body text-center"><div class="fs-4 fw-bold text-success"><?= $stats['paid'] ?></div><small class="text-muted">Paid</small></div></div></div>
    <div class="col-6 col-md-3"><div class="card border-0 shadow-sm"><div class="card-body text-center"><div class="fs-4 fw-bold text-danger"><?= $stats['unpaid'] ?></div><small class="text-muted">Unpaid</small></div></div></div>
</div>

<div class="row g-2 mb-3">
    <div class="col-md-4"><input type="text" id="psSearch" class="form-control" placeholder="Search by name or employee code..."></div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="payslipsTable">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Payslip #</th>
                    <th class="text-end">Basic</th>
                    <th class="text-end">Allowances</th>
                    <th class="text-end">PF</th>
                    <th class="text-end">Deductions</th>
                    <th class="text-end">Net</th>
                    <th>Status</th>
                    <th>Payment Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payslips as $p): ?>
                    <tr>
                        <td>
                            <strong><?= e($p['first_name'] . ' ' . $p['last_name']) ?></strong>
                            <div><small class="text-muted"><?= e($p['employee_code']) ?></small></div>
                        </td>
                        <td><span class="badge bg-light text-dark border"><?= e($p['payslip_number']) ?></span></td>
                        <td class="text-end"><?= money($p['basic_salary']) ?></td>
                        <td class="text-end text-success"><?= money($p['total_allowances']) ?></td>
                        <td class="text-end text-danger"><?= money($p['pf_amount']) ?></td>
                        <td class="text-end text-danger"><?= money($p['total_deductions']) ?></td>
                        <td class="text-end fw-semibold"><?= money($p['net_salary']) ?></td>
                        <td><?= status_badge($p['payment_status']) ?></td>
                        <td class="text-muted"><?= $p['payment_date'] ? format_date($p['payment_date']) : '-' ?></td>
                        <td class="text-end text-nowrap">
                            <?php if ($canEdit): ?>
                                <select class="form-select form-select-sm d-inline-block w-auto" data-status data-id="<?= $p['id'] ?>">
                                    <option value="unpaid" <?= $p['payment_status'] === 'unpaid' ? 'selected' : '' ?>>Unpaid</option>
                                    <option value="paid" <?= $p['payment_status'] === 'paid' ? 'selected' : '' ?>>Paid</option>
                                    <option value="partial" <?= $p['payment_status'] === 'partial' ? 'selected' : '' ?>>Partial</option>
                                </select>
                                <button class="btn btn-sm btn-outline-danger" data-remove data-id="<?= $p['id'] ?>" title="Delete"><i class="bi bi-trash"></i></button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<span id="psEmptyMsg" class="d-none">No payslips generated for <?= e($monthNames[$month]) ?> <?= $year ?> yet.</span>

<?php $scripts[] = <<<'JS'
<script>
$(function(){
    const csrf = $('meta[name="csrf-token"]').attr('content');

    const table = $('#payslipsTable').DataTable({
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        order: [],
        dom: '<"d-flex flex-wrap justify-content-between align-items-center mb-2"l>rt<"d-flex flex-wrap justify-content-between align-items-center mt-2"ip>',
        language: { emptyTable: $('#psEmptyMsg').text() }
    });

    $('#psSearch').on('input', function(){ table.search(this.value).draw(); });

    $('#psMonth, #psYear').on('change', function(){
        window.location = EMS_BASE + '/payslips?month=' + $('#psMonth').val() + '&year=' + $('#psYear').val();
    });

    $('#psGenerate').on('click', function(){
        Swal.fire({
            title: 'Generate payslips?',
            text: 'Create payslips for all employees with a salary structure for the selected month. Employees who already have a payslip are skipped.',
            icon: 'question', showCancelButton: true,
            confirmButtonColor: '#198754', confirmButtonText: 'Generate'
        }).then(function(result){
            if (!result.isConfirmed) return;
            $.ajax({
                url: EMS_BASE + '/payslips/generate', method: 'POST', dataType: 'json',
                data: { _token: csrf, month: $('#psMonth').val(), year: $('#psYear').val() },
                headers: { 'X-CSRF-TOKEN': csrf },
                success: function(r){ toast(r.message, 'success'); setTimeout(function(){ location.reload(); }, 800); },
                error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(e){ toast('Error', 'error'); } }
            });
        });
    });

    $(document).on('change', '[data-status]', function(){
        var id = $(this).data('id');
        $.ajax({
            url: EMS_BASE + '/payslips/update/' + id, method: 'POST', dataType: 'json',
            data: { _token: csrf, payment_status: $(this).val() },
            headers: { 'X-CSRF-TOKEN': csrf },
            success: function(r){ toast(r.message, 'success'); setTimeout(function(){ location.reload(); }, 800); },
            error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(e){ toast('Error', 'error'); } }
        });
    });

    $(document).on('click', '[data-remove]', function(){
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete payslip?', icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc3545', confirmButtonText: 'Delete'
        }).then(function(result){
            if (result.isConfirmed) {
                $.ajax({
                    url: EMS_BASE + '/payslips/delete/' + id, method: 'POST', dataType: 'json', data: { _token: csrf },
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
