<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Map URL paths to [ControllerClass, method].
| Controllers live in app/Controllers with a Controller suffix.
*/
return [
    // Authentication
    '/login'            => ['AuthController', 'login'],
    '/logout'           => ['AuthController', 'logout'],
    '/forgot-password'  => ['AuthController', 'forgotPassword'],
    '/reset-password'   => ['AuthController', 'resetPassword'],
    '/change-password'  => ['ProfileController', 'changePassword'],

    // Dashboard
    '/dashboard'        => ['DashboardController', 'index'],

    // Profile
    '/profile'          => ['ProfileController', 'index'],
    '/profile/update'   => ['ProfileController', 'update'],
    '/profile/avatar'   => ['ProfileController', 'updateAvatar'],

    // Users & security
    '/users'            => ['UserController', 'index'],
    '/users/create'     => ['UserController', 'create'],
    '/users/store'      => ['UserController', 'store'],
    '/users/edit'       => ['UserController', 'edit'],
    '/users/update'     => ['UserController', 'update'],
    '/users/delete'     => ['UserController', 'delete'],
    '/roles'            => ['RoleController', 'index'],
    '/roles/permissions'=> ['RoleController', 'permissions'],
    '/roles/assign'     => ['RoleController', 'assignPermission'],
    '/users/logs'       => ['UserController', 'activityLogs'],
    '/users/login-history' => ['UserController', 'loginHistory'],

    // Departments
    '/departments'      => ['DepartmentController', 'index'],
    '/departments/store'=> ['DepartmentController', 'store'],
    '/departments/update'=> ['DepartmentController', 'update'],
    '/departments/delete'=> ['DepartmentController', 'delete'],

    // Employees
    '/employees'        => ['EmployeeController', 'index'],
    '/employees/create' => ['EmployeeController', 'create'],
    '/employees/store'  => ['EmployeeController', 'store'],
    '/employees/edit'   => ['EmployeeController', 'edit'],
    '/employees/update' => ['EmployeeController', 'update'],
    '/employees/delete' => ['EmployeeController', 'delete'],
    '/employees/show'   => ['EmployeeController', 'show'],
    '/employees/table'  => ['EmployeeController', 'dataTable'],

    // Customers
    '/customers'        => ['CustomerController', 'index'],
    '/customers/store'  => ['CustomerController', 'store'],
    '/customers/update' => ['CustomerController', 'update'],
    '/customers/delete' => ['CustomerController', 'delete'],
    '/customers/table'  => ['CustomerController', 'dataTable'],

    // Holidays
    '/holidays'         => ['HolidayController', 'index'],
    '/holidays/store'   => ['HolidayController', 'store'],
    '/holidays/update'  => ['HolidayController', 'update'],
    '/holidays/delete'  => ['HolidayController', 'delete'],

    // Leave Applications
    '/leaves'           => ['LeaveController', 'index'],
    '/leaves/store'     => ['LeaveController', 'store'],
    '/leaves/show'      => ['LeaveController', 'show'],
    '/leaves/status'    => ['LeaveController', 'status'],
    '/leaves/delete'    => ['LeaveController', 'delete'],

    // Salary Structure
    '/salaries'         => ['SalaryController', 'index'],
    '/salaries/store'   => ['SalaryController', 'store'],
    '/salaries/update'  => ['SalaryController', 'update'],
    '/salaries/delete'  => ['SalaryController', 'delete'],

    // Payslips
    '/payslips'         => ['PayslipController', 'index'],
    '/payslips/generate'=> ['PayslipController', 'generate'],
    '/payslips/update'  => ['PayslipController', 'update'],
    '/payslips/delete'  => ['PayslipController', 'delete'],

    // Company Expenses
    '/expenses'         => ['ExpenseController', 'index'],
    '/expenses/store'   => ['ExpenseController', 'store'],
    '/expenses/update'  => ['ExpenseController', 'update'],
    '/expenses/status'  => ['ExpenseController', 'status'],
    '/expenses/delete'  => ['ExpenseController', 'delete'],

    // Task Board
    '/tasks'            => ['TaskController', 'index'],
    '/tasks/store'      => ['TaskController', 'store'],
    '/tasks/update'     => ['TaskController', 'update'],
    '/tasks/status'     => ['TaskController', 'status'],
    '/tasks/delete'     => ['TaskController', 'delete'],

    // Notice Board
    '/notices'          => ['NoticeController', 'index'],
    '/notices/store'    => ['NoticeController', 'store'],
    '/notices/update'   => ['NoticeController', 'update'],
    '/notices/delete'   => ['NoticeController', 'delete'],

    // Internal Chat
    '/chat'             => ['ChatController', 'index'],
    '/chat/contacts'    => ['ChatController', 'contacts'],
    '/chat/messages'    => ['ChatController', 'messages'],
    '/chat/send'        => ['ChatController', 'send'],

    // Settings
    '/settings'         => ['SettingController', 'index'],
    '/settings/save'    => ['SettingController', 'save'],

    // Notifications
    '/notifications/mark-read' => ['NotificationController', 'markRead'],
];