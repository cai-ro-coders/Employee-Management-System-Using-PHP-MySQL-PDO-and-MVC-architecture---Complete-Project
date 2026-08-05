<?php
use App\Models\Notification;

$currentUser = \Auth::user();
$activeRoute = ltrim((string) ($activeRoute ?? (parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '')), '/');
$activeRoute = ltrim(str_replace('devproject/employee_management_system/', '', $activeRoute), '/');
$activeKey = $activeRoute === 'dashboard' ? 'dashboard' : strtok($activeRoute, '/');
$notifModel = new Notification();
$unreadNotifications = $notifModel->unreadFor(\Auth::id());
$recentNotifications = $notifModel->recentFor(\Auth::id(), 6);
$fullName = $currentUser['first_name'] . ' ' . $currentUser['last_name'];
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <title><?= e($title ?? 'Dashboard') ?> - <?= e(setting('system_name', 'EMS')) ?></title>
    <link rel="stylesheet" href="<?= asset('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
</head>
<body>
<div class="app-shell">

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-briefcase-fill"></i></div>
            <div class="brand-text">
                <strong><?= e(setting('short_name', 'EMS')) ?></strong>
                <small><?= e(setting('system_name', 'Employee Mgmt')) ?></small>
            </div>
        </div>
        <div class="sidebar-body">
            <?php
            $nav = [
                ['group', 'Main'],
                ['link', 'Dashboard', 'dashboard', 'bi bi-speedometer2', 'dashboard', null],
                ['group', 'Employee Management'],
                ['link', 'All Employees', 'employees', 'bi bi-people', 'employees', 'employees.view'],
                ['link', 'Add Employee', 'employees/create', 'bi bi-person-plus', 'employees_create', 'employees.create'],
                ['group', 'Organization'],
                ['link', 'Departments', 'departments', 'bi bi-diagram-3', 'departments', 'departments.manage'],
                ['link', 'Company Holidays', 'holidays', 'bi bi-calendar2-heart', 'holidays', 'holidays.manage'],
                ['group', 'Time & Attendance'],
                ['link', 'Leave Applications', 'leaves', 'bi bi-calendar-check', 'leaves', 'leave.review'],
                ['group', 'Payroll & Finance'],
                ['link', 'Salary Structure', 'salaries', 'bi bi-cash-stack', 'salaries', 'payroll.view'],
                ['link', 'Generate Payslips', 'payslips', 'bi bi-receipt', 'payslips', 'payroll.generate'],
                ['link', 'Company Expenses', 'expenses', 'bi bi-wallet2', 'expenses', 'expenses.manage'],
                ['group', 'Workplace'],
                ['link', 'Task Board', 'tasks', 'bi bi-kanban', 'tasks', 'tasks.manage'],
                ['link', 'Notice Board', 'notices', 'bi bi-megaphone', 'notices', 'notices.manage'],
                ['link', 'Internal Chat', 'chat', 'bi bi-chat-dots', 'chat', null],
                ['group', 'User & Security'],
                ['link', 'Manage Users', 'users', 'bi bi-person-gear', 'users', 'users.manage'],
                ['link', 'Roles & Permissions', 'roles/permissions', 'bi bi-key', 'roles', 'roles.manage'],
                ['link', 'Activity Logs', 'users/logs', 'bi bi-list-check', 'users_logs', null],
                ['link', 'Login History', 'users/login-history', 'bi bi-shield-check', 'users_login_history', null],
                ['group', 'Settings'],
                ['link', 'Settings', 'settings', 'bi bi-gear', 'settings', 'settings.manage'],
                ['group', 'Account'],
                ['link', 'My Profile', 'profile', 'bi bi-person-circle', 'profile', null],
                ['link', 'Logout', 'logout', 'bi bi-box-arrow-right', 'logout', null],
            ];
            $activeExact = false;
            foreach ($nav as $item) {
                if ($item[0] === 'link' && ltrim($item[2], '/') === $activeRoute) {
                    $activeExact = true;
                    break;
                }
            }
            echo '<ul class="sidebar-nav">';
            foreach ($nav as $item) {
                if ($item[0] === 'group') {
                    echo '<li class="nav-group">' . e($item[1]) . '</li>';
                } else {
                    $perm = $item[5];
                    if ($perm !== null && !\Auth::can($perm)) { continue; }
                    echo '<li class="nav-item">
                        <a class="nav-link ' . ((ltrim($item[2], '/') === $activeRoute || (!$activeExact && $activeKey === $item[4])) ? 'active' : '') . '" href="' . url($item[2]) . '">
                            <i class="' . $item[3] . '"></i><span>' . e($item[1]) . '</span>
                        </a></li>';
                }
            }
            echo '</ul>';
            ?>
        </div>
    </aside>
    <div class="sidebar-overlay" data-sidebar-toggle></div>

    <div class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button class="btn btn-icon btn-outline d-lg-none" data-sidebar-toggle><i class="bi bi-list"></i></button>
                <div class="d-none d-sm-block"><strong class="page-heading"><?= e($title ?? 'Dashboard') ?></strong></div>
            </div>
            <div class="topbar-right">
                <button class="btn btn-icon btn-outline" data-theme-toggle title="Toggle theme"><i class="bi bi-moon-stars"></i></button>

                <div class="dropdown">
                    <button class="btn btn-icon btn-outline position-relative" data-bs-toggle="dropdown" data-bs-auto-close="outside" title="Notifications">
                        <i class="bi bi-bell"></i>
                        <?php if ($unreadNotifications > 0): ?><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?= $unreadNotifications ?></span><?php endif; ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end notif-dropdown shadow p-0">
                        <div class="dropdown-header d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">Notifications</span>
                            <button type="button" class="btn btn-sm btn-link p-0" data-nf-mark-read><small>Mark all read</small></button>
                        </div>
                        <div class="list-group list-group-flush">
                            <?php if (empty($recentNotifications)): ?>
                                <div class="dropdown-item text-muted text-center py-3">No notifications</div>
                            <?php else: foreach ($recentNotifications as $n): ?>
                                <div class="list-group-item">
                                    <strong><?= e($n['title']) ?></strong>
                                    <div class="small text-muted"><?= e($n['message']) ?></div>
                                    <small class="text-muted"><?= time_ago($n['created_at']) ?></small>
                                </div>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="btn user-chip dropdown-toggle" data-bs-toggle="dropdown">
                        <span class="avatar-holder"><i class="bi bi-person-fill"></i></span>
                        <span class="d-none d-md-block text-start ms-2">
                            <strong class="d-block" style="line-height:1"><?= e($fullName) ?></strong>
                            <small class="muted"><?= e($currentUser['role_name']) ?></small>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end shadow">
                        <div class="dropdown-header"><?= e($currentUser['email']) ?></div>
                        <a class="dropdown-item" href="<?= url('profile') ?>"><i class="bi bi-person me-2"></i>My Profile</a>
                        <a class="dropdown-item" href="<?= url('users/login-history') ?>"><i class="bi bi-shield-check me-2"></i>Login History</a>
                        <a class="dropdown-item" href="<?= url('change-password') ?>"><i class="bi bi-key me-2"></i>Change Password</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="<?= url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="content">
            <div class="container-fluid">
                <?php flash(); ?>
                <?= $content ?>
            </div>
        </main>
    </div>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer" style="z-index:1056"></div>

<script>window.EMS_BASE = '<?= rtrim(url(''), '/') ?>';</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?= asset('js/bootstrap.bundle.min.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<?php if (isset($scripts)) foreach ((array) $scripts as $s): echo $s; endforeach; ?>
<script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>