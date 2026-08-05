<?php
declare(strict_types=1);

/**
 * Database Seeder
 *
 * Usage: php database/seeders/seed.php
 * Applies database/migrations/schema.sql then populates realistic data.
 */

require dirname(__DIR__, 2) . '/app/core/Bootstrap.php';

use App\Core\Database;
use App\Core\Config;

$pdo = Database::connect();
$out = function ($msg) { echo $msg . PHP_EOL; };

$out("=== EMS_db Seeder ===");

// 1) Apply schema (re-runnable)
$schemaFile = BASE_PATH . '/database/migrations/schema.sql';
$pdo->exec("SET FOREIGN_KEY_CHECKS=0");
$schema = file_get_contents($schemaFile);
// strip the CREATE DATABASE/USE lines (already connected)
$schema = preg_replace('/^CREATE DATABASE[^;]*;/is', '', $schema);
$schema = preg_replace('/^USE\s+`EMS_db`;/is', '', $schema);
$pdo->exec($schema);
$pdo->exec("SET FOREIGN_KEY_CHECKS=1");
$out("+ Schema applied");

/* ---------------- Roles ---------------- */
$roles = [
    ['Super Admin',  'Full system access and control'],
    ['Admin',        'Administrative management access'],
    ['HR',           'Human resources management'],
    ['Manager',      'Departmental management'],
    ['Employee',     'Standard employee access'],
];
foreach ($roles as [$name, $desc]) {
    Database::insert('roles', ['name' => $name, 'description' => $desc]);
}
$roleIds = ['super_admin' => 1, 'admin' => 2, 'hr' => 3, 'manager' => 4, 'employee' => 5];
$out('+ Roles: 5');

/* ---------------- Permissions ---------------- */
$permissions = [
    ['Dashboard',       'View',             'dashboard.view'],
    ['Employees',       'View',             'employees.view'],
    ['Employees',       'Create',           'employees.create'],
    ['Employees',       'Edit',             'employees.edit'],
    ['Employees',       'Delete',           'employees.delete'],
    ['Departments',     'Manage',           'departments.manage'],
    ['Holidays',        'Manage',           'holidays.manage'],
    ['Customers',       'View',             'customers.view'],
    ['Customers',       'Create',           'customers.create'],
    ['Customers',       'Edit',             'customers.edit'],
    ['Customers',       'Delete',           'customers.delete'],
    ['Attendance',      'Manage',           'attendance.manage'],
    ['Leave',           'Apply',            'leave.apply'],
    ['Leave',           'Review',           'leave.review'],
    ['Payroll',         'View',             'payroll.view'],
    ['Payroll',         'Generate',         'payroll.generate'],
    ['Expenses',        'Manage',           'expenses.manage'],
    ['Tasks',           'Manage',           'tasks.manage'],
    ['Notices',         'Manage',           'notices.manage'],
    ['Users',           'Manage',           'users.manage'],
    ['Roles',           'Manage',           'roles.manage'],
    ['Reports',         'View',             'reports.view'],
    ['Settings',        'Manage',           'settings.manage'],
];
$permIds = [];
foreach ($permissions as [$mod, $act, $key]) {
    $permIds[$key] = Database::insert('permissions', [
        'module_name' => $mod, 'action_name' => $act, 'permission_key' => $key,
    ]);
}
$out('+ Permissions: ' . count($permissions));

$grantAll = function ($roleId) use ($permIds) {
    foreach ($permIds as $id) {
        Database::insert('role_permissions', ['role_id' => $roleId, 'permission_id' => $id]);
    }
};
$grantAll($roleIds['super_admin']);
$grantAll($roleIds['admin']);
$grantAll($roleIds['hr']);
// Manager: subset
foreach (['dashboard.view','employees.view','customers.view','attendance.manage','leave.apply','leave.review','payroll.view','expenses.manage','tasks.manage','notices.manage','reports.view'] as $key) {
    Database::insert('role_permissions', ['role_id' => $roleIds['manager'], 'permission_id' => $permIds[$key]]);
}
// Employee: basic
foreach (['dashboard.view','leave.apply','tasks.manage','employees.view'] as $key) {
    Database::insert('role_permissions', ['role_id' => $roleIds['employee'], 'permission_id' => $permIds[$key]]);
}
$out('+ Role permissions assigned');

/* ---------------- Departments ---------------- */
$departments = [
    ['Engineering', 'ENG'], ['Human Resources', 'HRD'], ['Finance', 'FIN'],
    ['Marketing', 'MKT'], ['Sales', 'SAL'], ['Operations', 'OPS'],
    ['IT Support', 'ITS'], ['Design', 'DES'],
];
$deptIds = [];
foreach ($departments as [$name, $code]) {
    $deptIds[$name] = Database::insert('departments', ['name' => $name, 'code' => $code]);
}
$out('+ Departments: ' . count($departments));

/* ---------------- Users (50) ---------------- */
$firstNames = ['James','Mary','John','Patricia','Robert','Jennifer','Michael','Linda','William','Elizabeth','David','Susan','Joseph','Jessica','Thomas','Sarah','Charles','Karen','Chris','Lisa','Daniel','Nancy','Matthew','Betty','Anthony','Sandra','Mark','Ashley','Donald','Emily','Steven','Kimberly','Paul','Donna','Andrew','Michelle','Josh','Carol','Kevin','Amanda','Brian','Melissa','George','Deborah','Eric','Stephanie','Kenneth','Rebecca','Edward','Sharon','Ramil','Jose','Mia','Elena'];
$lastNames  = ['Smith','Johnson','Williams','Brown','Jones','Garcia','Miller','Davis','Rodriguez','Martinez','Hernandez','Lopez','Gonzalez','Wilson','Anderson','Thomas','Taylor','Moore','Jackson','Martin','Lee','Perez','Thompson','White','Harris','Sanchez','Clark','Ramirez','Lewis','Robinson','Walker','Young','Allen','King','Wright','Scott','Torres','Nguyen','Hill','Flores','Green','Adams','Nelson','Baker','Hall','Rivera','Campbell','Mitchell','Carter','Roberts','Dela Cruz','Santos','Reyes','Bautista'];

$defaultPass = password_hash('password123', PASSWORD_DEFAULT);

// Admins (Super Admin x1, Admin x2, HR x2, Managers x4)
$userData = [];
$userData[] = ['role' => $roleIds['super_admin'], 'fn' => 'Rey', 'ln' => 'Malonzo', 'u' => 'admin', 'e' => 'admin@ems.local'];
$userData[] = ['role' => $roleIds['admin'], 'fn' => 'Grace', 'ln' => 'Lee', 'u' => 'g.lee', 'e' => 'grace.lee@ems.local'];
$userData[] = ['role' => $roleIds['admin'], 'fn' => 'Kevin', 'ln' => 'Cruz', 'u' => 'k.cruz', 'e' => 'kevin.cruz@ems.local'];
$userData[] = ['role' => $roleIds['hr'], 'fn' => 'Anna', 'ln' => 'Reyes', 'u' => 'a.reyes', 'e' => 'anna.reyes@ems.local'];
$userData[] = ['role' => $roleIds['hr'], 'fn' => 'Maya', 'ln' => 'Ramos', 'u' => 'm.ramos', 'e' => 'maya.ramos@ems.local'];
foreach (['admin' => 'Capacity' ] as $ignore => $d) {}
$managerNames = ['Maria','Jose','Luz','Ben'];
for ($i = 0; $i < 4; $i++) {
    $userData[] = ['role' => $roleIds['manager'], 'fn' => $managerNames[$i], 'ln' => $lastNames[($i * 3) % count($lastNames)], 'u' => 'mgr' . ($i + 1), 'e' => 'manager' . ($i + 1) . '@ems.local'];
}

// Remaining as employees to reach 50 users total
while (count($userData) < 50) {
    $i = count($userData);
    $fn = $firstNames[(($i * 7) + 3) % count($firstNames)];
    $ln = $lastNames[(($i * 11) + 5) % count($lastNames)];
    $userData[] = [
        'role' => $roleIds['employee'],
        'fn' => $fn, 'ln' => $ln,
        'u' => strtolower($fn[0]) . strtolower($ln) . $i,
        'e' => strtolower($fn) . '.' . strtolower($ln) . $i . '@ems.local',
    ];
}

foreach ($userData as $i => $ud) {
    $userId = Database::insert('users', [
        'role_id' => $ud['role'], 'first_name' => $ud['fn'], 'last_name' => $ud['ln'],
        'username' => $ud['u'], 'email' => $ud['e'], 'password' => $defaultPass,
        'phone' => '09' . rand(10, 99) . rand(1000000, 9999999),
        'address' => rand(1, 999) . ' ' . ['Main St','Oak Ave','Pine Rd','Sunset Blvd','Riverside Dr'][$i % 5] . ', Manila',
        'status' => 'active',
        'last_login' => date('Y-m-d H:i:s', time() - rand(0, 86400 * 5)),
    ]);
}
$out('+ Users: 50');

/* ---------------- Employees (50, matching the 50 users) ---------------- */
$designations = ['Software Engineer', 'HR Specialist', 'Accountant', 'Marketing Lead', 'Sales Executive', 'Operations Analyst', 'IT Support', 'Graphic Designer', 'Project Coordinator', 'QA Tester'];
// build employees for user ids 1..50
for ($i = 1; $i <= 50; $i++) {
    $designation = $designations[($i * 3) % count($designations)];
    $dept = $departments[($i * 7) % count($departments)][0];
    $salary = rand(22000, 95000) + 0.99;
    Database::insert('employees', [
        'user_id' => $i,
        'department_id' => $deptIds[$dept],
        'employee_code' => 'EMP' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
        'designation' => $designation,
        'salary' => $salary,
        'joining_date' => date('Y-m-d', strtotime('-' . rand(3, 900) . ' days')),
    ]);
}
$out('+ Employees: 50');

/* ---------------- Attendance (last 30 days for employees) ---------------- */
$today = strtotime(date('Y-m-d'));
for ($emp = 1; $emp <= 50; $emp++) {
    for ($d = 0; $d < 30; $d++) {
        $day = date('Y-m-d', $today - $d * 86400);
        $dow = (int) date('N', strtotime($day)); // 1=Mon..7=Sun
        if ($dow > 5) { continue; } // skip weekends
        $status = 'present';
        $clockIn = '08:' . str_pad((string) rand(0, 55), 2, '0', STR_PAD_LEFT) . ':00';
        $clockOut = '17:' . str_pad((string) rand(0, 55), 2, '0', STR_PAD_LEFT) . ':00';
        if ($emp === ($d % 50) && $d % 13 === 0) {
            $status = 'on_leave'; $clockIn = $clockOut = null;
        } elseif (rand(0, 25) === 0) {
            $status = 'absent'; $clockIn = $clockOut = null;
        }
        Database::insert('attendance', [
            'employee_id' => $emp, 'date' => $day,
            'clock_in' => $clockIn, 'clock_out' => $clockOut,
            'status' => $status, 'notes' => $status === 'present' ? null : ($status === 'on_leave' ? 'On approved leave' : 'No record'),
        ]);
    }
}
$out('+ Attendance: ~600 records');

/* ---------------- Leave applications ---------------- */
$leaveTypes = ['sick', 'casual', 'annual', 'maternity'];
$nonAdminUsers = range(15, 50);
for ($i = 0; $i < 25; $i++) {
    $emp = $i + 3;
    $type = $leaveTypes[$i % count($leaveTypes)];
    $start = $today - rand(0, 60) * 86400;
    $days = rand(1, 4);
    $end = $start + ($days - 1) * 86400;
    $statusVals = ['pending', 'approved', 'approved', 'rejected'];
    $status = $statusVals[$i % count($statusVals)];
    Database::insert('leave_applications', [
        'employee_id' => $emp,
        'leave_type' => $type,
        'start_date' => date('Y-m-d', $start),
        'end_date' => date('Y-m-d', $end),
        'total_days' => $days,
        'reason' => $i % 4 === 0 ? 'Medical appointment' : ($i % 4 === 1 ? 'Family matter' : ($i % 4 === 2 ? 'Personal leave' : 'Urgent personal work')),
        'status' => $status,
        'reviewed_by' => $status === 'pending' ? null : 1,
        'review_notes' => $status === 'approved' ? 'Approved' : ($status === 'rejected' ? 'Rejected due to scheduling conflict' : null),
    ]);
}
$out('+ Leave applications: 25');

/* ---------------- Customers (40) ---------------- */
$industries = ['Technology', 'Finance', 'Healthcare', 'Retail', 'Manufacturing', 'Education', 'Real Estate'];
$companies = ['AlphaTech', 'BetaWorks', 'GammaSoft', 'DeltaCorp', 'OmegaLabs', 'NovaSys', 'ZenithCo', 'PrimeDigital'];
for ($i = 1; $i <= 40; $i++) {
    $fn = $firstNames[($i * 5) % count($firstNames)];
    $ln = $lastNames[($i * 9) % count($lastNames)];
    Database::insert('customers', [
        'first_name' => $fn, 'last_name' => $ln,
        'company' => ($i % 3 === 0) ? $companies[$i % count($companies)] . ' Inc' : null,
        'email' => strtolower($fn) . '.' . strtolower($ln) . $i . '@client.com',
        'phone' => '0917' . rand(1000000, 9999999),
        'mobile' => '0922' . rand(1000000, 9999999),
        'website' => $i % 4 === 0 ? 'www.' . strtolower($ln) . '.com' : null,
        'industry' => $industries[$i % count($industries)],
        'customer_type' => $i % 2 === 0 ? 'business' : 'individual',
        'status' => $i % 10 === 5 ? 'inactive' : 'active',
        'address' => rand(1, 999) . ' Commerce St',
        'city' => ['Manila', 'Quezon City', 'Makati', 'Cebu', 'Davao'][$i % 5],
        'state' => 'Metro Manila',
        'country' => 'Philippines',
        'postal_code' => (string) (1000 + $i),
        'notes' => $i % 7 === 0 ? 'Priority account' : null,
    ]);
}
$out('+ Customers: 40');

/* ---------------- Customer notes & tags ---------------- */
foreach ([1, 3, 5, 9, 14, 21, 33] as $cid) {
    Database::insert('customer_notes', [
        'customer_id' => $cid, 'user_id' => 1,
        'note' => 'Initial follow-up call completed.',
    ]);
}
foreach (['VIP', 'New Lead', 'Existing', 'Partner'] as $tag) {
    Database::insert('customer_tags', ['name' => $tag]);
}
$out('+ Customer notes & tags');

/* ---------------- Notifications ---------------- */
for ($i = 0; $i < 15; $i++) {
    Database::insert('notifications', [
        'user_id' => 1,
        'title' => ['Leave approved', 'New task assigned', 'Expense approved', 'Employee joined'][$i % 4],
        'message' => 'A recent system event needs your attention (sample #' . ($i + 1) . ').',
        'type' => ['info', 'success', 'warning'][$i % 3],
        'is_read' => $i > 10 ? 1 : 0,
    ]);
}
$out('+ Notifications: 15');

/* ---------------- Holidays ---------------- */
foreach ([
    ['New Year\'s Day', '-0 days'], ['Maundy Thursday', '-40 days'], ['Good Friday', '-39 days'],
    ['Labor Day', '-90 days'], ['Independence Day', '-150 days'], ['Christmas Day', '+140 days'],
] as [$name, $offset]) {
    Database::insert('holidays', [
        'event_name' => $name,
        'start_date' => date('Y-m-d', strtotime($offset)),
        'end_date' => date('Y-m-d', strtotime($offset)),
        'description' => 'Public holiday',
    ]);
}
$out('+ Holidays: 6');

/* ---------------- Notices ---------------- */
Database::insert('notices', ['title' => 'Office Renovation Notice', 'content' => 'Please avoid the 2nd floor hallway this week due to renovation works.', 'posted_by' => 1]);
Database::insert('notices', ['title' => 'New HR Policy', 'content' => 'Work-from-home policy updated for Q3. Please read the full policy document.', 'posted_by' => 1]);
$out('+ Notices: 2');

/* ---------------- Tasks ---------------- */
for ($i = 1; $i <= 12; $i++) {
    Database::insert('tasks', [
        'title' => ['Design sprint', 'Code review', 'Client meeting', 'Database migration', 'Weekly report', 'API integration'][$i % 6],
        'description' => 'Sample task generated by seeder.',
        'assigned_by' => 1,
        'assigned_to' => rand(1, 50),
        'due_date' => date('Y-m-d', strtotime('+' . rand(0, 20) . ' days')),
        'priority' => ['low', 'medium', 'high', 'urgent'][$i % 4],
        'status' => ['todo', 'in_progress', 'done'][$i % 3],
    ]);
}
$out('+ Tasks: 12');

/* ---------------- Expenses ---------------- */
for ($i = 1; $i <= 12; $i++) {
    Database::insert('expenses', [
        'title' => ['Office supplies', 'Team lunch', 'Software license', 'Travel reimbursement', 'Equipment purchase'][$i % 5],
        'category' => ['Operations', 'Food', 'Software', 'Travel', 'Equipment'][$i % 5],
        'amount' => rand(500, 50000) + 0.5,
        'expense_date' => date('Y-m-d', strtotime('-' . rand(0, 45) . ' days')),
        'purchased_by' => 1,
        'status' => ['pending', 'approved', 'approved', 'rejected'][$i % 4],
    ]);
}
$out('+ Expenses: 12');

/* ---------------- Salaries & Payslips ---------------- */
$lastMonth = (int) date('n');
$year = (int) date('Y');
for ($i = 1; $i <= 50; $i++) {
    $base = rand(20000, 60000);
    $hra = round($base * 0.2, 2);
    $med = round($base * 0.1, 2);
    $other = round($base * 0.05, 2);
    Database::insert('salaries', [
        'employee_id' => $i, 'basic_salary' => $base,
        'house_rent_allowance' => $hra, 'medical_allowance' => $med, 'other_allowances' => $other,
        'pf_deduction_rate' => 12, 'tax_deduction' => round($base * 0.05, 2),
    ]);
    $allowances = $hra + $med + $other;
    $pf = round($base * 0.12, 2);
    $tax = round($base * 0.05, 2);
    $net = $base + $allowances - $pf - $tax;
    $psId = Database::insert('payslips', [
        'employee_id' => $i, 'payslip_number' => 'PS' . $year . '-' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
        'month' => $lastMonth, 'year' => $year,
        'basic_salary' => $base, 'total_allowances' => $allowances, 'total_deductions' => $pf + $tax,
        'pf_amount' => $pf, 'net_salary' => round($net, 2),
        'payment_status' => $i % 4 === 0 ? 'paid' : 'unpaid',
        'payment_date' => $i % 4 === 0 ? date('Y-m-d', strtotime('last day of last month')) : null,
    ]);
    Database::insert('provident_funds', [
        'employee_id' => $i, 'payslip_id' => $psId,
        'employee_contribution' => $pf, 'employer_contribution' => round($pf * 1.1, 2),
        'total_amount' => round($pf * 2.1, 2),
        'date_added' => date('Y-m-d', strtotime('last day of last month')),
    ]);
}
$out('+ Salaries & Payslips: 50');

/* ---------------- Settings ---------------- */
$settings = [
    ['company_name', 'Acme Corporation'],
    ['company_email', 'support@acmecorp.local'],
    ['company_phone', '+1 (555) 123-4567'],
    ['company_address', '123 Business Ave, Suite 500'],
    ['company_logo', '', 'general'],
    ['currency', 'PHP'],
    ['currency_symbol', '₱'],
    ['timezone', 'Asia/Manila'],
    ['language', 'English'],
    ['date_format', 'M d, Y'],
    ['theme', 'light'],
    ['smtp_host', 'smtp.example.com'],
    ['smtp_port', '587'],
    ['smtp_username', ''],
    ['smtp_password', ''],
    ['smtp_encryption', 'tls'],
    ['system_name', 'Employee Management System'],
];
foreach ($settings as [$key, $value]) {
    Database::insert('settings', ['setting_key' => $key, 'setting_value' => $value, 'group_name' => 'general']);
}
$out('+ Settings: ' . count($settings));

/* ---------------- Menu items ---------------- */
$menu = [
    ['Dashboard', '/dashboard', 'bi bi-speedometer2', 'dashboard.view', 1],
];
foreach ($menu as [$title, $url, $icon, $perm, $sort]) {
    Database::insert('menu_items', ['title' => $title, 'url' => $url, 'icon_class' => $icon, 'permission_key' => $perm, 'sort_order' => $sort]);
}

/* ---------------- Seed data summary ---------------- */
$out('');
$out('=== Seeder complete ===');
$out('Default password for all users: password123');
$out('Login: admin / password123');