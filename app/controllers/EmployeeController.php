<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Core\Session;
use \Upload as Uploader;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;

class EmployeeController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('employees.view');
        $this->view('employees/index', [
            'title'       => 'All Employees',
            'departments' => (new Department())->allActive(),
        ]);
    }

    public function dataTable(): void
    {
        $this->requirePermission('employees.view');
        $search = trim((string) Request::query('search', ''));
        $dept = (int) Request::query('department', 0);
        $employees = (new Employee())->searchableList($search ?: null, $dept ?: null);
        $this->json(['data' => $employees]);
    }

    public function create(): void
    {
        $this->requirePermission('employees.create');
        $this->view('employees/create', [
            'title'       => 'Add Employee',
            'departments' => (new Department())->allActive(),
            'roles'       => (new \App\Models\Role())->all('name'),
        ]);
    }

    public function store(): void
    {
        $this->requirePermission('employees.create');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            Session::flash('error', 'Invalid security token.');
            $this->redirectBack();
        }

$first = trim((string) Request::post('first_name', ''));
        $last  = trim((string) Request::post('last_name', ''));
        $email = trim((string) Request::post('email', ''));
        $password = (string) Request::post('password', 'password123');
        $deptId = (int) Request::post('department_id', 0);
        $designation = trim((string) Request::post('designation', ''));
        $salary = (float) Request::post('salary', 0);

        if ($first === '' || $last === '' || $email === '' || $deptId === 0) {
            Session::flash('error', 'First name, last name, email and department are required.');
            $this->redirectBack();
        }

        $username = strtolower($first[0]) . strtolower(str_replace(' ', '', $last)) . rand(10, 99);

        $avatar = null;
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            try {
                $avatar = Uploader::store($_FILES['avatar'], 'avatars', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            } catch (\RuntimeException $e) {
                Session::flash('error', $e->getMessage());
                $this->redirectBack();
            }
        }

        try {
            Database::transaction(function () use ($first, $last, $email, $username, $password, $deptId, $designation, $salary, $avatar) {
                $userId = Database::insert('users', [
                    'role_id' => 5, // Employee
                    'first_name' => $first, 'last_name' => $last,
                    'username' => $username, 'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'phone' => trim((string) Request::post('phone', '')),
                    'avatar' => $avatar,
                    'status' => 'active',
                ]);
                $code = 'EMP' . str_pad((string) $userId, 4, '0', STR_PAD_LEFT);
                Database::insert('employees', [
                    'user_id' => $userId, 'department_id' => $deptId,
                    'employee_code' => $code, 'designation' => $designation,
                    'salary' => $salary,
                    'joining_date' => Request::post('joining_date', '') ?: date('Y-m-d'),
                ]);
            });
        } catch (\Throwable $e) {
            Session::flash('error', 'Failed to create employee: ' . $e->getMessage());
            $this->redirectBack();
        }

        log_activity('create', 'employees', "Hired {$first} {$last}");
        Session::flash('success', 'Employee added successfully.');
        $this->redirect('employees');
    }

    public function show(int $id): void
    {
        $this->requirePermission('employees.view');
        $employee = (new Employee())->withDetails($id);
        if (!$employee) {
            Session::flash('error', 'Employee not found.');
            $this->redirect('employees');
        }
        $this->view('employees/show', [
            'title'    => 'Employee Profile',
            'employee' => $employee,
            'bank'     => (new Employee())->bankDetails($id),
            'documents'=> (new Employee())->documents($id),
            'attendance'=> (new Employee())->attendance($id, 10),
        ]);
    }

    public function edit(int $id): void
    {
        $this->requirePermission('employees.edit');
        $employee = (new Employee())->withDetails($id);
        if (!$employee) {
            Session::flash('error', 'Employee not found.');
            $this->redirect('employees');
        }
        $this->view('employees/edit', [
            'title'       => 'Edit Employee',
            'employee'    => $employee,
            'departments' => (new Department())->allActive(),
            'bank'        => (new Employee())->bankDetails($id),
            'documents'   => (new Employee())->documents($id),
        ]);
    }

    public function storeDocument(int $id): void
    {
        $this->requirePermission('employees.edit');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            Session::flash('error', 'Invalid security token.');
            $this->redirectBack();
        }
        $title = trim((string) Request::post('document_title', ''));
        if ($title === '' || !isset($_FILES['document_file']) || $_FILES['document_file']['error'] !== UPLOAD_ERR_OK) {
            Session::flash('error', 'Document title and file are required.');
            $this->redirectBack();
        }
        try {
            $path = Uploader::store($_FILES['document_file'], 'employees', ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'csv', 'jpg', 'jpeg', 'png', 'gif', 'webp']);
        } catch (\RuntimeException $e) {
            Session::flash('error', $e->getMessage());
            $this->redirectBack();
        }
        Database::insert('employee_documents', [
            'employee_id'    => $id,
            'document_title' => $title,
            'document_file'  => $path,
            'file_type'      => strtoupper((string) pathinfo($_FILES['document_file']['name'], PATHINFO_EXTENSION)),
            'uploaded_at'    => date('Y-m-d H:i:s'),
        ]);
        log_activity('create', 'employee_documents', "Uploaded document '{$title}' for employee #{$id}");
        Session::flash('success', 'Document uploaded.');
        $this->redirectBack();
    }

    public function deleteDocument(int $id): void
    {
        $this->requirePermission('employees.edit');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }
        $doc = Database::fetchOne('SELECT * FROM employee_documents WHERE id = :id', ['id' => $id]);
        if (!$doc) {
            $this->json(['success' => false, 'message' => 'Document not found.'], 404);
        }
        Uploader::delete($doc['document_file']);
        Database::delete('employee_documents', 'id = :id', ['id' => $id]);
        log_activity('delete', 'employee_documents', "Deleted document #{$id}");
        $this->json(['success' => true, 'message' => 'Document deleted.']);
    }

    public function update(int $id): void
    {
        $this->requirePermission('employees.edit');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            Session::flash('error', 'Invalid security token.');
            $this->redirectBack();
        }

        $deptId = (int) Request::post('department_id', 0);
        $designation = trim((string) Request::post('designation', ''));
        $salary = (float) Request::post('salary', 0);

        Database::update('employees', [
            'department_id' => $deptId,
            'designation' => $designation,
            'salary' => $salary,
            'joining_date' => Request::post('joining_date', '') ?: date('Y-m-d'),
        ], 'id = :id', ['id' => $id]);

        $emp = Database::fetchOne('SELECT user_id, avatar FROM employees e JOIN users u ON u.id = e.user_id WHERE e.id = :id', ['id' => $id]);
        if ($emp) {
            $userData = [
                'first_name' => trim((string) Request::post('first_name', '')),
                'last_name'  => trim((string) Request::post('last_name', '')),
                'phone'      => trim((string) Request::post('phone', '')),
            ];
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                try {
                    $newAvatar = Uploader::store($_FILES['avatar'], 'avatars', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    $userData['avatar'] = $newAvatar;
                } catch (\RuntimeException $e) {
                    Session::flash('error', $e->getMessage());
                    $this->redirectBack();
                }
            }
            Database::update('users', $userData, 'id = :id', ['id' => $emp['user_id']]);
            if (!empty($userData['avatar'])) {
                Uploader::delete($emp['avatar']);
            }
        }

        // Bank details (upsert)
        $bankData = [
            'bank_name' => trim((string) Request::post('bank_name', '')),
            'branch_name' => trim((string) Request::post('branch_name', '')),
            'account_number' => trim((string) Request::post('account_number', '')),
            'account_title' => trim((string) Request::post('account_title', '')),
            'ifsc_swift_code' => trim((string) Request::post('ifsc_swift_code', '')),
            'tax_id_pan' => trim((string) Request::post('tax_id_pan', '')),
        ];
        $existing = Database::fetchOne('SELECT id FROM employee_bank_details WHERE employee_id = :id', ['id' => $id]);
        if ($existing) {
            Database::update('employee_bank_details', $bankData, 'employee_id = :id', ['id' => $id]);
        } elseif (array_filter($bankData, fn($v) => $v !== '')) {
            Database::insert('employee_bank_details', array_merge(['employee_id' => $id], $bankData));
        }

        log_activity('update', 'employees', "Updated employee #{$id}");
        Session::flash('success', 'Employee updated.');
        $this->redirectBack();
    }

    public function delete(int $id): void
    {
        $this->requirePermission('employees.delete');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }
        $emp = Database::fetchOne('SELECT user_id FROM employees WHERE id = :id', ['id' => $id]);
        Database::delete('employees', 'id = :id', ['id' => $id]);
        if ($emp) {
            Database::delete('users', 'id = :id', ['id' => $emp['user_id']]);
        }
        log_activity('delete', 'employees', "Deleted employee #{$id}");
        $this->json(['success' => true, 'message' => 'Employee deleted.']);
    }
}