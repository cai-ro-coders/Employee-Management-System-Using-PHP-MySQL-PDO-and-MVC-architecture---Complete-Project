<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Core\Session;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('departments.manage');
        $this->view('departments/index', [
            'title'       => 'Departments',
            'departments' => (new Department())->withEmployeeCount(),
        ]);
    }

    public function store(): void
    {
        $this->requirePermission('departments.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $name = trim((string) Request::post('name', ''));
        $code = trim((string) Request::post('code', ''));
        if ($name === '' || $code === '') {
            $this->json(['success' => false, 'message' => 'Name and code are required.'], 422);
        }

        $dupe = (int) Database::fetchColumn('SELECT COUNT(*) FROM departments WHERE code = :c', ['c' => $code], 0);
        if ($dupe > 0) {
            $this->json(['success' => false, 'message' => 'Department code already exists.'], 422);
        }

        Database::insert('departments', [
            'name' => $name, 'code' => strtoupper($code),
            'status' => Request::post('status', 'active') === 'active' ? 'active' : 'inactive',
        ]);
        log_activity('create', 'departments', "Created department {$name}");
        $this->json(['success' => true, 'message' => 'Department created.']);
    }

    public function update(int $id): void
    {
        $this->requirePermission('departments.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $name = trim((string) Request::post('name', ''));
        $code = trim((string) Request::post('code', ''));
        if ($name === '' || $code === '') {
            $this->json(['success' => false, 'message' => 'Name and code are required.'], 422);
        }

        $dupe = (int) Database::fetchColumn(
            'SELECT COUNT(*) FROM departments WHERE code = :c AND id != :id', ['c' => $code, 'id' => $id], 0
        );
        if ($dupe > 0) {
            $this->json(['success' => false, 'message' => 'Department code already exists.'], 422);
        }

        Database::update('departments', [
            'name' => $name, 'code' => strtoupper($code),
            'status' => Request::post('status', 'active') === 'active' ? 'active' : 'inactive',
        ], 'id = :id', ['id' => $id]);

        log_activity('update', 'departments', "Updated department {$name}");
        $this->json(['success' => true, 'message' => 'Department updated.']);
    }

    public function delete(int $id): void
    {
        $this->requirePermission('departments.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $count = (int) Database::fetchColumn('SELECT COUNT(*) FROM employees WHERE department_id = :id', ['id' => $id], 0);
        if ($count > 0) {
            $this->json(['success' => false, 'message' => "Cannot delete: {$count} employee(s) assigned to this department."], 422);
        }

        Database::delete('departments', 'id = :id', ['id' => $id]);
        log_activity('delete', 'departments', "Deleted department #{$id}");
        $this->json(['success' => true, 'message' => 'Department deleted.']);
    }
}
