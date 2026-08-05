<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div><h5 class="fw-bold mb-0">Company Expenses</h5><small class="text-muted">Track and approve company expenses</small></div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#expenseModal" data-mode="create"><i class="bi bi-plus-lg"></i> Add Expense</button>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100 border-0">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-wallet2"></i></div>
                <div class="ms-3">
                    <div class="stat-label">Total Expenses</div>
                    <div class="stat-value"><?= money($stats['total']) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100 border-0">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-warning-subtle text-warning"><i class="bi bi-hourglass-split"></i></div>
                <div class="ms-3">
                    <div class="stat-label">Pending</div>
                    <div class="stat-value"><?= $stats['pending'] ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100 border-0">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-success-subtle text-success"><i class="bi bi-check-circle"></i></div>
                <div class="ms-3">
                    <div class="stat-label">Approved</div>
                    <div class="stat-value"><?= $stats['approved'] ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100 border-0">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-danger-subtle text-danger"><i class="bi bi-x-circle"></i></div>
                <div class="ms-3">
                    <div class="stat-label">Rejected</div>
                    <div class="stat-value"><?= $stats['rejected'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-2 mb-3">
    <div class="col-md-4"><input type="text" id="expenseSearch" class="form-control" placeholder="Search expenses..."></div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="expensesTable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th class="text-end">Amount</th>
                    <th>Expense Date</th>
                    <th>Purchased By</th>
                    <th>Receipt</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($expenses as $x): ?>
                    <tr>
                        <td><strong><?= e($x['title']) ?></strong></td>
                        <td><?= $x['category'] ? e($x['category']) : '-' ?></td>
                        <td class="text-end fw-semibold"><?= money($x['amount']) ?></td>
                        <td><?= format_date($x['expense_date']) ?></td>
                        <td><?= $x['purchased_by'] ? e($x['first_name'] . ' ' . $x['last_name']) : '-' ?></td>
                        <td>
                            <?php if ($x['receipt_file']): ?>
                                <a class="btn btn-sm btn-outline-secondary" href="<?= asset('uploads/' . $x['receipt_file']) ?>" target="_blank" title="View receipt"><i class="bi bi-paperclip"></i></a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td><?= status_badge($x['status']) ?></td>
                        <td class="text-end text-nowrap">
                            <?php if ($x['status'] === 'pending'): ?>
                                <button class="btn btn-sm btn-outline-success" data-status data-id="<?= $x['id'] ?>" data-status-value="approved" title="Approve"><i class="bi bi-check-lg"></i></button>
                                <button class="btn btn-sm btn-outline-danger" data-status data-id="<?= $x['id'] ?>" data-status-value="rejected" title="Reject"><i class="bi bi-x-lg"></i></button>
                            <?php endif; ?>
                            <button class="btn btn-sm btn-outline-primary" data-edit
                                data-id="<?= $x['id'] ?>"
                                data-title="<?= e($x['title']) ?>"
                                data-category="<?= e($x['category'] ?? '') ?>"
                                data-amount="<?= $x['amount'] ?>"
                                data-date="<?= e($x['expense_date']) ?>"
                                data-by="<?= $x['purchased_by'] ?>"
                                data-status-value="<?= e($x['status']) ?>"
                                data-receipt="<?= e($x['receipt_file'] ?? '') ?>"
                                title="Edit"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger" data-remove data-id="<?= $x['id'] ?>" title="Delete"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<span id="expenseEmptyMsg" class="d-none">No expenses recorded yet.</span>

<!-- Modal -->
<div class="modal fade" id="expenseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="expenseForm" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="expenseId">
                <div class="modal-header">
                    <h5 class="modal-title" id="expenseModalTitle">Add Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" id="expenseTitle" class="form-control" required placeholder="e.g. Office supplies">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" id="expenseCategory" class="form-control" placeholder="e.g. Operations">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Amount</label>
                            <input type="number" step="0.01" min="0" name="amount" id="expenseAmount" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Expense Date</label>
                            <input type="date" name="expense_date" id="expenseDate" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Purchased By</label>
                            <select name="purchased_by" id="expenseBy" class="form-select">
                                <option value="">Select user</option>
                                <?php foreach ($users as $u): ?>
                                    <option value="<?= $u['id'] ?>"><?= e($u['first_name'] . ' ' . $u['last_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" id="expenseStatus" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Receipt File</label>
                            <input type="file" name="receipt_file" id="expenseReceipt" class="form-control" accept="image/*,.pdf">
                            <small class="text-muted" id="expenseReceiptHint"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Expense</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $scripts[] = <<<'JS'
<script>
$(function(){
    const csrf = $('meta[name="csrf-token"]').attr('content');

    const table = $('#expensesTable').DataTable({
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        order: [],
        dom: '<"d-flex flex-wrap justify-content-between align-items-center mb-2"l>rt<"d-flex flex-wrap justify-content-between align-items-center mt-2"ip>',
        language: { emptyTable: $('#expenseEmptyMsg').text() }
    });

    $('#expenseSearch').on('input', function(){ table.search(this.value).draw(); });

    $('#expenseModal').on('show.bs.modal', function(){
        if (!$(this).find('#expenseId').val()) {
            $('#expenseForm')[0].reset();
            $('#expenseModalTitle').text('Add Expense');
            $('#expenseReceiptHint').text('');
        }
    });

    $(document).on('click', '[data-edit]', function(){
        var el = $(this);
        $('#expenseId').val(el.data('id'));
        $('#expenseTitle').val(el.data('title'));
        $('#expenseCategory').val(el.data('category'));
        $('#expenseAmount').val(el.data('amount'));
        $('#expenseDate').val(el.data('date'));
        $('#expenseBy').val(el.data('by') || '');
        $('#expenseStatus').val(el.data('status-value'));
        $('#expenseReceipt').val('');
        $('#expenseReceiptHint').text(el.data('receipt') ? 'Keep current file unless you choose a new one.' : '');
        $('#expenseModalTitle').text('Edit Expense');
        new bootstrap.Modal(document.getElementById('expenseModal')).show();
    });

    $('#expenseForm').on('submit', function(e){
        e.preventDefault();
        const id = $('#expenseId').val();
        const url = id ? (EMS_BASE + '/expenses/update/' + id) : (EMS_BASE + '/expenses/store');
        const formData = new FormData(this);
        $.ajax({
            url: url, method: 'POST', dataType: 'json', data: formData,
            processData: false, contentType: false,
            headers: { 'X-CSRF-TOKEN': csrf },
            success: function(r){ toast(r.message, 'success'); bootstrap.Modal.getInstance(document.getElementById('expenseModal')).hide(); setTimeout(function(){ location.reload(); }, 800); },
            error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(x){ toast('Error', 'error'); } }
        });
    });

    $(document).on('click', '[data-status]', function(){
        var id = $(this).data('id');
        var status = $(this).data('status-value');
        Swal.fire({
            title: 'Mark as ' + (status === 'approved' ? 'approved' : 'rejected') + '?', icon: 'question', showCancelButton: true,
            confirmButtonColor: status === 'approved' ? '#198754' : '#dc3545', confirmButtonText: 'Yes'
        }).then(function(result){
            if (result.isConfirmed) {
                $.ajax({
                    url: EMS_BASE + '/expenses/status/' + id, method: 'POST', dataType: 'json', data: { _token: csrf, status: status },
                    headers: { 'X-CSRF-TOKEN': csrf },
                    success: function(r){ toast(r.message, 'success'); setTimeout(function(){ location.reload(); }, 800); },
                    error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(e){ toast('Error', 'error'); } }
                });
            }
        });
    });

    $(document).on('click', '[data-remove]', function(){
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete expense?', icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc3545', confirmButtonText: 'Delete'
        }).then(function(result){
            if (result.isConfirmed) {
                $.ajax({
                    url: EMS_BASE + '/expenses/delete/' + id, method: 'POST', dataType: 'json', data: { _token: csrf },
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
