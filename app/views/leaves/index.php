<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div><h5 class="fw-bold mb-0">Leave Applications</h5><small class="text-muted">Review and manage employee leave requests</small></div>
    <?php if ($canApply): ?>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leaveModal"><i class="bi bi-plus-lg"></i> Apply Leave</button>
    <?php endif; ?>
</div>

<!-- Stats -->
<div class="row g-3 mb-3">
    <div class="col-6 col-md-3"><div class="card border-0 shadow-sm"><div class="card-body text-center"><div class="fs-4 fw-bold text-primary"><?= $stats['applied'] ?></div><small class="text-muted">Total Applied</small></div></div></div>
    <div class="col-6 col-md-3"><div class="card border-0 shadow-sm"><div class="card-body text-center"><div class="fs-4 fw-bold text-success"><?= $stats['approved'] ?></div><small class="text-muted">Approved</small></div></div></div>
    <div class="col-6 col-md-3"><div class="card border-0 shadow-sm"><div class="card-body text-center"><div class="fs-4 fw-bold text-warning"><?= $stats['pending'] ?></div><small class="text-muted">Pending</small></div></div></div>
    <div class="col-6 col-md-3"><div class="card border-0 shadow-sm"><div class="card-body text-center"><div class="fs-4 fw-bold text-danger"><?= $stats['rejected'] ?></div><small class="text-muted">Rejected</small></div></div></div>
</div>

<div class="row g-2 mb-3">
    <div class="col-md-4"><input type="text" id="leaveSearch" class="form-control" placeholder="Search by name or employee code..."></div>
    <div class="col-md-3"><select id="leaveStatus" class="form-select"><option value="">All statuses</option><option value="pending">Pending</option><option value="approved">Approved</option><option value="rejected">Rejected</option></select></div>
    <div class="col-md-3"><select id="leaveType" class="form-select"><option value="">All types</option><option value="sick">Sick</option><option value="casual">Casual</option><option value="annual">Annual</option><option value="maternity">Maternity</option><option value="paternity">Paternity</option><option value="unpaid">Unpaid</option></select></div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="leavesTable">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Type</th>
                    <th>Dates</th>
                    <th>Days</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Reviewed By</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaves as $l): ?>
                <tr data-status="<?= e($l['status']) ?>" data-type="<?= e($l['leave_type']) ?>">
                    <td>
                        <strong><?= e($l['first_name'] . ' ' . $l['last_name']) ?></strong>
                        <div><small class="text-muted"><?= e($l['employee_code']) ?></small></div>
                    </td>
                    <td><span class="badge bg-secondary"><?= e(ucfirst($l['leave_type'])) ?></span></td>
                    <td class="text-muted"><?= format_date($l['start_date']) ?> → <?= format_date($l['end_date']) ?></td>
                    <td><?= $l['total_days'] ?></td>
                    <td class="text-truncate" style="max-width:220px"><?= e($l['reason'] ?? '') ?></td>
                    <td><?= status_badge($l['status']) ?></td>
                    <td>
                        <?php if ($l['reviewer_first']): ?>
                            <small><?= e($l['reviewer_first'] . ' ' . $l['reviewer_last']) ?><?= $l['review_notes'] ? ' &middot; ' . e($l['review_notes']) : '' ?></small>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end text-nowrap">
                        <button class="btn btn-sm btn-outline-secondary" data-view data-id="<?= $l['id'] ?>" title="View Details"><i class="bi bi-eye"></i></button>
                        <?php if ($l['status'] === 'pending'): ?>
                            <button class="btn btn-sm btn-outline-success" data-review data-id="<?= $l['id'] ?>" data-action="approved" title="Approve"><i class="bi bi-check-lg"></i></button>
                            <button class="btn btn-sm btn-outline-warning" data-review data-id="<?= $l['id'] ?>" data-action="rejected" title="Reject"><i class="bi bi-x-lg"></i></button>
                        <?php endif; ?>
                        <button class="btn btn-sm btn-outline-danger" data-remove data-id="<?= $l['id'] ?>" title="Delete"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- View Details Modal -->
<div class="modal fade" id="leaveViewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Leave Application Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3">
                            <div id="lv_avatar" class="avatar-holder fs-4"></div>
                            <div>
                                <div id="lv_name" class="fw-bold fs-6"></div>
                                <div id="lv_code" class="small text-muted"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div id="lv_status"></div>
                        <small id="lv_department" class="text-muted"></small>
                    </div>
                </div>
                <hr>
                <div class="row g-3">
                    <div class="col-md-4"><small class="text-muted d-block">Leave Type</small><strong id="lv_type"></strong></div>
                    <div class="col-md-4"><small class="text-muted d-block">Start Date</small><strong id="lv_start"></strong></div>
                    <div class="col-md-4"><small class="text-muted d-block">End Date</small><strong id="lv_end"></strong></div>
                    <div class="col-md-4"><small class="text-muted d-block">Duration</small><strong id="lv_days"></strong></div>
                    <div class="col-md-4"><small class="text-muted d-block">Applied On</small><strong id="lv_created"></strong></div>
                    <div class="col-md-4"><small class="text-muted d-block">Reviewer</small><strong id="lv_reviewer"></strong></div>
                </div>
                <div class="mt-3">
                    <small class="text-muted d-block">Reason</small>
                    <div id="lv_reason" class="border rounded p-2 bg-light"></div>
                </div>
                <div class="mt-3">
                    <small class="text-muted d-block">Review Notes</small>
                    <div id="lv_notes" class="border rounded p-2 bg-light"></div>
                </div>
                <div class="mt-3" id="lv_review_wrap" style="display:none">
                    <label class="form-label">Add Review Note</label>
                    <textarea id="lv_review_note" class="form-control" rows="2" placeholder="Optional note for this decision"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success" id="lvApprove" style="display:none"><i class="bi bi-check-lg"></i> Approve</button>
                <button type="button" class="btn btn-outline-danger" id="lvReject" style="display:none"><i class="bi bi-x-lg"></i> Reject</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Apply Leave Modal -->
<div class="modal fade" id="leaveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="leaveForm">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Apply Leave</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Employee</label>
                        <select name="employee_id" class="form-select" required>
                            <option value="">Select employee</option>
                            <?php foreach ($employees as $emp): ?>
                                <option value="<?= $emp['id'] ?>"><?= e($emp['first_name'] . ' ' . $emp['last_name']) ?> (<?= e($emp['employee_code']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Leave Type</label>
                        <select name="leave_type" class="form-select" required>
                            <option value="">Select type</option>
                            <option value="sick">Sick</option>
                            <option value="casual">Casual</option>
                            <option value="annual">Annual</option>
                            <option value="maternity">Maternity</option>
                            <option value="paternity">Paternity</option>
                            <option value="unpaid">Unpaid</option>
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Start Date</label><input type="date" name="start_date" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">End Date</label><input type="date" name="end_date" class="form-control" required></div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label class="form-label">Reason</label>
                        <textarea name="reason" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Leave</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $scripts[] = <<<'JS'
<script>
$(function(){
    const csrf = $('meta[name="csrf-token"]').attr('content');

    const table = $('#leavesTable').DataTable({
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        order: [],
        dom: '<"d-flex flex-wrap justify-content-between align-items-center mb-2"l>rt<"d-flex flex-wrap justify-content-between align-items-center mt-2"ip>'
    });

    $('#leaveSearch').on('input', function(){ table.search(this.value).draw(); });
    $('#leaveStatus').on('change', function(){ table.column(5).search(this.value).draw(); });
    $('#leaveType').on('change', function(){ table.column(1).search(this.value).draw(); });

    $('#leaveForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: EMS_BASE + '/leaves/store', method: 'POST', dataType: 'json', data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': csrf },
            success: function(r){ toast(r.message, 'success'); bootstrap.Modal.getInstance(document.getElementById('leaveModal')).hide(); setTimeout(function(){ location.reload(); }, 800); },
            error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(x){ toast('Error', 'error'); } }
        });
    });

    let leaveViewId = null;

    $(document).on('click', '[data-view]', function(){
        var id = $(this).data('id');
        $.ajax({
            url: EMS_BASE + '/leaves/show/' + id, method: 'GET', dataType: 'json',
            success: function(r){
                var d = r.data;
                leaveViewId = d.id;
                $('#lv_name').text(d.first_name + ' ' + d.last_name);
                $('#lv_code').text(d.employee_code + ' &middot; ' + (d.designation || ''));
                $('#lv_department').text(d.department_name || '');
                var badge = { approved: ['bg-success', 'Approved'], pending: ['bg-warning', 'Pending'], rejected: ['bg-danger', 'Rejected'] }[d.status] || ['bg-secondary', d.status];
                $('#lv_status').html('<span class="badge ' + badge[0] + '">' + badge[1] + '</span>');
                $('#lv_type').text(d.leave_type.charAt(0).toUpperCase() + d.leave_type.slice(1));
                $('#lv_start').text(d.start_date);
                $('#lv_end').text(d.end_date);
                $('#lv_days').text(d.total_days + ' day' + (d.total_days > 1 ? 's' : ''));
                $('#lv_created').text(d.created_at);
                $('#lv_reviewer').text(d.reviewer_first ? d.reviewer_first + ' ' + d.reviewer_last : '-');
                $('#lv_reason').text(d.reason || '-');
                $('#lv_notes').text(d.review_notes || '-');
                $('#lv_review_note').val('');
                var pending = d.status === 'pending';
                $('#lvApprove, #lvReject, #lv_review_wrap').toggle(pending);
                new bootstrap.Modal(document.getElementById('leaveViewModal')).show();
            },
            error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(e){ toast('Error', 'error'); } }
        });
    });

    $('#lvApprove, #lvReject').on('click', function(){
        if (!leaveViewId) return;
        var action = this.id === 'lvApprove' ? 'approved' : 'rejected';
        Swal.fire({
            title: action === 'approved' ? 'Approve this leave?' : 'Reject this leave?',
            icon: action === 'approved' ? 'success' : 'warning', showCancelButton: true,
            confirmButtonColor: action === 'approved' ? '#198754' : '#dc3545',
            confirmButtonText: action === 'approved' ? 'Approve' : 'Reject'
        }).then(function(result){
            if (!result.isConfirmed) return;
            $.ajax({
                url: EMS_BASE + '/leaves/status/' + leaveViewId, method: 'POST', dataType: 'json',
                data: { _token: csrf, status: action, review_notes: $('#lv_review_note').val() || '' },
                headers: { 'X-CSRF-TOKEN': csrf },
                success: function(r){ toast(r.message, 'success'); bootstrap.Modal.getInstance(document.getElementById('leaveViewModal')).hide(); setTimeout(function(){ location.reload(); }, 800); },
                error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(e){ toast('Error', 'error'); } }
            });
        });
    });

    $(document).on('click', '[data-review]', function(){
        var id = $(this).data('id');
        var action = $(this).data('action');
        Swal.fire({
            title: action === 'approved' ? 'Approve this leave?' : 'Reject this leave?',
            input: 'textarea', inputPlaceholder: 'Review notes (optional)',
            icon: action === 'approved' ? 'success' : 'warning', showCancelButton: true,
            confirmButtonColor: action === 'approved' ? '#198754' : '#dc3545',
            confirmButtonText: action === 'approved' ? 'Approve' : 'Reject'
        }).then(function(result){
            if (!result.isConfirmed) return;
            $.ajax({
                url: EMS_BASE + '/leaves/status/' + id, method: 'POST', dataType: 'json',
                data: { _token: csrf, status: action, review_notes: result.value || '' },
                headers: { 'X-CSRF-TOKEN': csrf },
                success: function(r){ toast(r.message, 'success'); setTimeout(function(){ location.reload(); }, 800); },
                error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(e){ toast('Error', 'error'); } }
            });
        });
    });

    $(document).on('click', '[data-remove]', function(){
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete leave application?', icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc3545', confirmButtonText: 'Delete'
        }).then(function(result){
            if (result.isConfirmed) {
                $.ajax({
                    url: EMS_BASE + '/leaves/delete/' + id, method: 'POST', dataType: 'json', data: { _token: csrf },
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
