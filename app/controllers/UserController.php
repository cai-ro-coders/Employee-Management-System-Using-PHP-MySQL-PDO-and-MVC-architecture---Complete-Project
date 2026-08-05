<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Core\Session;
use App\Models\Role;
use App\Models\ActivityLog;
use App\Models\User;

class UserController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('users.manage');
        $users = (new User())->allWithRole();
        $roles = (new Role())->all('name');

        $this->view('users/index', [
            'title' => 'Manage Users',
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function create(): void
    {
        $this->requirePermission('users.manage');
        $this->view('users/create', [
            'title' => 'Add User',
            'roles' => (new Role())->all('name'),
        ]);
    }

    public function store(): void
    {
        $this->requirePermission('users.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $first = trim((string) Request::post('first_name', ''));
        $last  = trim((string) Request::post('last_name', ''));
        $username = trim((string) Request::post('username', ''));
        $email = trim((string) Request::post('email', ''));
        $password = (string) Request::post('password', '');
        $roleId = (int) Request::post('role_id', 0);

        $fail = function (string $message) {
            if (Request::isAjax()) {
                $this->json(['success' => false, 'message' => $message], 422);
            }
            Session::flash('error', $message);
            $this->redirectBack();
        };

        if ($first === '' || $last === '' || $username === '' || $email === '' || $password === '' || $roleId === 0) {
            $fail('All fields are required.');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $fail('Valid email required.');
        }
        if (strlen($password) < 8) {
            $fail('Password must be at least 8 characters.');
        }

        $exists = (int) Database::fetchColumn(
            'SELECT COUNT(*) FROM users WHERE email = :e OR username = :u',
            ['e' => $email, 'u' => $username], 0
        );
        if ($exists > 0) {
            $fail('Email or username already taken.');
        }

        $userId = Database::insert('users', [
            'role_id' => $roleId, 'first_name' => $first, 'last_name' => $last,
            'username' => $username, 'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'phone' => trim((string) Request::post('phone', '')),
            'status' => Request::post('status', 'active') === 'active' ? 'active' : 'inactive',
        ]);

        log_activity('create', 'users', "Created user {$email}");
        if (Request::isAjax()) {
            $this->json(['success' => true, 'message' => 'User created successfully.', 'redirect' => url('users')]);
        }
        Session::flash('success', 'User created successfully.');
        $this->redirect('users');
    }

    public function edit(int $id): void
    {
        $this->requirePermission('users.manage');
        $user = (new User())->withRole($id);
        if (!$user) {
            Session::flash('error', 'User not found.');
            $this->redirect('users');
        }
        $this->view('users/edit', [
            'title' => 'Edit User',
            'user'  => $user,
            'roles' => (new Role())->all('name'),
        ]);
    }

    public function update(int $id): void
    {
        $this->requirePermission('users.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $data = [
            'role_id'    => (int) Request::post('role_id', 0),
            'first_name' => trim((string) Request::post('first_name', '')),
            'last_name'  => trim((string) Request::post('last_name', '')),
            'email'      => trim((string) Request::post('email', '')),
            'username'   => trim((string) Request::post('username', '')),
            'phone'      => trim((string) Request::post('phone', '')),
            'status'     => Request::post('status', 'active') === 'active' ? 'active' : 'inactive',
        ];

        if ($data['role_id'] === 0 || $data['first_name'] === '' || $data['last_name'] === '') {
            $this->json(['success' => false, 'message' => 'Required fields missing.'], 422);
        }

        $dupe = (int) Database::fetchColumn(
            'SELECT COUNT(*) FROM users WHERE id != :id AND (email = :e OR username = :u)',
            ['id' => $id, 'e' => $data['email'], 'u' => $data['username']], 0
        );
        if ($dupe > 0) {
            $this->json(['success' => false, 'message' => 'Email or username already taken.'], 422);
        }

        Database::update('users', $data, 'id = :id', ['id' => $id]);

        $newPass = (string) Request::post('password', '');
        if ($newPass !== '') {
            if (strlen($newPass) < 8) {
                $this->json(['success' => false, 'message' => 'New password must be at least 8 characters.'], 422);
            }
            Database::update('users', ['password' => password_hash($newPass, PASSWORD_DEFAULT)], 'id = :id', ['id' => $id]);
        }

        log_activity('update', 'users', "Updated user #{$id}");
        if (Request::isAjax()) {
            $this->json(['success' => true, 'message' => 'User updated.', 'redirect' => url('users')]);
        }
        Session::flash('success', 'User updated.');
        $this->redirect('users');
    }

    public function delete(int $id): void
    {
        $this->requirePermission('users.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }
        if ($id === \Auth::id()) {
            $this->json(['success' => false, 'message' => 'You cannot delete your own account.'], 422);
        }
        Database::delete('users', 'id = :id', ['id' => $id]);
        log_activity('delete', 'users', "Deleted user #{$id}");
        $this->json(['success' => true, 'message' => 'User deleted.']);
    }

    public function activityLogs(): void
    {
        $this->requireAuth();
        $search = trim((string) Request::query('q', ''));
        $module = trim((string) Request::query('module', ''));
        $page = max(1, (int) Request::query('page', 1));
        $data = (new ActivityLog())->paginated($page, 15, $search ?: null, $module ?: null);

        $this->view('users/activity-logs', [
            'title' => 'Activity Logs',
            'logs'  => $data,
            'search'=> $search,
            'module'=> $module,
        ]);
    }

    public function loginHistory(): void
    {
        $this->requireAuth();
        $page = max(1, (int) Request::query('page', 1));
        $search = trim((string) Request::query('q', ''));
        $data = (new User())->loginHistoryAll($page, 15, $search ?: null);

        $this->view('users/login-history', [
            'title' => 'Login History',
            'logs'  => $data,
            'search'=> $search,
        ]);
    }
}