<div class="d-flex justify-content-between align-items-center mb-3">
    <div><h5 class="fw-bold mb-0">Employee Profile</h5><small class="text-muted"><?= e($employee['employee_code']) ?></small></div>
    <a href="<?= url('employees') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                <img src="<?= $employee['avatar'] ? asset('uploads/' . $employee['avatar']) : avatar(null, $employee['first_name'] . ' ' . $employee['last_name']) ?>" class="rounded-circle mb-3" style="width:96px;height:96px;object-fit:cover" alt="">
                <h5 class="fw-bold mb-1"><?= e($employee['first_name'] . ' ' . $employee['last_name']) ?></h5>
                <div class="text-muted"><?= e($employee['designation']) ?></div>
                <div class="mt-2"><?= status_badge($employee['user_status']) ?></div>
                <hr>
                <div class="text-start small">
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">Employee Code</span><strong><?= e($employee['employee_code']) ?></strong></div>
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">Email</span><strong><?= e($employee['email']) ?></strong></div>
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">Phone</span><strong><?= e($employee['phone']) ?></strong></div>
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">Department</span><strong><?= e($employee['department_name']) ?></strong></div>
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">Joining Date</span><strong><?= format_date($employee['joining_date']) ?></strong></div>
                    <div class="d-flex justify-content-between"><span class="text-muted">Salary</span><strong><?= money($employee['salary']) ?></strong></div>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-transparent"><strong>Bank Details</strong></div>
            <?php if ($bank): ?>
                <div class="card-body small">
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">Bank</span><strong><?= e($bank['bank_name']) ?></strong></div>
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">Account No.</span><strong><?= e($bank['account_number']) ?></strong></div>
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">Title</span><strong><?= e($bank['account_title']) ?></strong></div>
                    <div class="d-flex justify-content-between"><span class="text-muted">PAN</span><strong><?= e($bank['tax_id_pan']) ?></strong></div>
                </div>
            <?php else: ?>
                <div class="card-body text-muted small">No bank details on file.</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent"><strong>Recent Attendance</strong></div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead><tr><th>Date</th><th>In</th><th>Out</th><th>Status</th><th>Notes</th></tr></thead>
                    <tbody>
                    <?php foreach ($attendance as $a): ?>
                        <tr>
                            <td><?= format_date($a['date']) ?></td>
                            <td><?= $a['clock_in'] ?? '-' ?></td>
                            <td><?= $a['clock_out'] ?? '-' ?></td>
                            <td><?= status_badge($a['status']) ?></td>
                            <td class="text-muted"><?= e($a['notes']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-transparent"><strong>Documents</strong></div>
            <div class="card-body">
                <?php if (empty($documents)): ?>
                    <div class="text-muted">No documents uploaded.</div>
                <?php else: ?>
                    <div class="row g-2">
                        <?php foreach ($documents as $doc): ?>
                            <div class="col-md-6">
                                <a href="<?= asset('uploads/' . $doc['document_file']) ?>" target="_blank" class="d-flex align-items-center text-decoration-none">
                                    <i class="bi bi-file-earmark-text fs-4 me-2 text-primary"></i>
                                    <div>
                                        <strong class="d-block text-body"><?= e($doc['document_title']) ?></strong>
                                        <small class="text-muted"><?= e($doc['file_type']) ?> · <?= time_ago($doc['uploaded_at']) ?></small>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>