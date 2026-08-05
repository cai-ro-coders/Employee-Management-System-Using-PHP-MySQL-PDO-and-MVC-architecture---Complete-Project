<div class="row g-3 mb-4">
    <!-- Stat cards -->
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100 border-0">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-people"></i></div>
                <div class="ms-3">
                    <div class="stat-label">Total Employees</div>
                    <div class="stat-value"><?= number_format($totalEmployees) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100 border-0">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-success-subtle text-success"><i class="bi bi-briefcase"></i></div>
                <div class="ms-3">
                    <div class="stat-label">Total Customers</div>
                    <div class="stat-value"><?= number_format($totalCustomers) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100 border-0">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-warning-subtle text-warning"><i class="bi bi-cash-coin"></i></div>
                <div class="ms-3">
                    <div class="stat-label">Monthly Pay</div>
                    <div class="stat-value"><?= money($monthlyPay) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100 border-0">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-info-subtle text-info"><i class="bi bi-calendar-check"></i></div>
                <div class="ms-3">
                    <div class="stat-label">On Leave Today</div>
                    <div class="stat-value"><?= count($onLeaveToday) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leave status small cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3"><div class="card border-0 shadow-sm"><div class="card-body text-center"><div class="fs-4 fw-bold text-primary"><?= $leaveStats['applied'] ?></div><small class="text-muted">Leave Applied</small></div></div></div>
    <div class="col-6 col-md-3"><div class="card border-0 shadow-sm"><div class="card-body text-center"><div class="fs-4 fw-bold text-success"><?= $leaveStats['approved'] ?></div><small class="text-muted">Leave Approved</small></div></div></div>
    <div class="col-6 col-md-3"><div class="card border-0 shadow-sm"><div class="card-body text-center"><div class="fs-4 fw-bold text-warning"><?= $leaveStats['pending'] ?></div><small class="text-muted">Leave Pending</small></div></div></div>
    <div class="col-6 col-md-3"><div class="card border-0 shadow-sm"><div class="card-body text-center"><div class="fs-4 fw-bold text-danger"><?= $leaveStats['rejected'] ?></div><small class="text-muted">Leave Rejected</small></div></div></div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent"><strong>Revenue vs Headcount</strong></div>
            <div class="card-body">
                <canvas id="revenueChart" height="110"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent"><strong>Department Distribution</strong></div>
            <div class="card-body">
                <canvas id="deptChart" height="160"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent"><strong>Live Activity Feed</strong></div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush feed-list">
                    <?php foreach ($recentActivities as $act): ?>
                    <li class="list-group-item d-flex align-items-start">
                        <span class="feed-dot bg-<?= $act['action'] === 'delete' ? 'danger' : 'primary' ?>"></span>
                        <div>
                            <strong><?= e($act['first_name'] . ' ' . $act['last_name']) ?></strong>
                            <span class="text-muted"><?= e($act['action']) ?></span> <?= e($act['module']) ?>
                            <div class="small text-muted"><?= e($act['description']) ?></div>
                            <small class="text-muted"><?= time_ago($act['created_at']) ?></small>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent"><strong>Recent Leave Applications</strong></div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead><tr><th>Employee</th><th>Type</th><th>Dates</th><th>Days</th><th>Status</th></tr></thead>
                    <tbody>
                    <?php foreach ($recentLeaves as $l): ?>
                        <tr>
                            <td><strong><?= e($l['first_name'] . ' ' . $l['last_name']) ?></strong></td>
                            <td><span class="badge bg-secondary"><?= e(ucfirst($l['leave_type'])) ?></span></td>
                            <td class="text-muted"><?= format_date($l['start_date']) ?> → <?= format_date($l['end_date']) ?></td>
                            <td><?= $l['total_days'] ?></td>
                            <td><?= status_badge($l['status']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$monthsJson = json_encode($chartMonths);
$revenueJson = json_encode($chartRevenue);
$headcountJson = json_encode($chartHeadcount);
$deptLabelsJson = json_encode(array_column($deptDistribution, 'name'));
$deptDataJson = json_encode(array_map('intval', array_column($deptDistribution, 'total')));
$scripts[] = <<<JS
<script>
$(function(){
    const months = $monthsJson;
    const revenue = $revenueJson;
    const headcount = $headcountJson;
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [
                { label: 'Revenue', data: revenue, backgroundColor: 'rgba(99,102,241,.75)', borderRadius: 6 },
                { label: 'Headcount', data: headcount, type: 'line', borderColor: '#22c55e', backgroundColor: 'rgba(34,197,94,.15)', fill: true, tension: .4 }
            ]
        },
        options: { maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: true } } }
    });
    const deptLabels = $deptLabelsJson;
    const deptData = $deptDataJson;
    new Chart(document.getElementById('deptChart'), {
        type: 'doughnut',
        data: { labels: deptLabels, datasets: [{ data: deptData, backgroundColor: ['#6366f1','#22c55e','#f59e0b','#06b6d4','#ef4444','#8b5cf6','#14b8a6','#f97316'] }] },
        options: { maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { boxWidth: 10 } } } }
    });
});
</script>
JS;
?>
