<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Core\Session;
use App\Models\Role;

class RoleController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('roles.manage');

        $roles = [];
        foreach ((new Role())->all('name') as $role) {
            $role['user_count'] = (new Role())->usersCount($role['id']);
            $roles[] = $role;
        }

        $this->view('roles/index', [
            'title' => 'Roles',
            'roles' => $roles,
        ]);
    }

    public function permissions(): void
    {
        $this->requirePermission('roles.manage');

        $roles = (new Role())->all('name');
        $permissions = (new Role())->allPermissions();

        // Group permissions by module
        $modules = [];
        foreach ($permissions as $perm) {
            $modules[$perm['module_name']][] = $perm;
        }

        // role_id => set of permission keys
        $rolePerms = [];
        foreach ($roles as $role) {
            foreach ((new Role())->permissions($role['id']) as $p) {
                $rolePerms[$role['id']][$p['permission_key']] = true;
            }
        }

        $this->view('roles/permissions', [
            'title'     => 'Roles & Permissions',
            'roles'     => $roles,
            'modules'   => $modules,
            'rolePerms' => $rolePerms,
        ]);
    }

    public function assignPermission(): void
    {
        $this->requirePermission('roles.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $roleId = (int) Request::post('role_id', 0);
        $permissionId = (int) Request::post('permission_id', 0);
        $checked = Request::post('checked', '') === 'true' || Request::post('checked', '') === '1';

        if (!$roleId || !$permissionId) {
            $this->json(['success' => false, 'message' => 'Missing parameters.'], 422);
        }

        // Protect Super Admin role from having permissions revoked.
        $role = (new Role())->find($roleId);
        if ($role && strtolower($role['name']) === 'super admin') {
            $this->json(['success' => false, 'message' => 'Super Admin permissions are fixed.'], 422);
        }

        if ($checked) {
            Database::insert('role_permissions', ['role_id' => $roleId, 'permission_id' => $permissionId]);
        } else {
            Database::delete('role_permissions', 'role_id = :r AND permission_id = :p', ['r' => $roleId, 'p' => $permissionId]);
        }

        log_activity('update', 'roles', "Permission #{$permissionId} " . ($checked ? 'granted to' : 'revoked from') . " role #{$roleId}");
        $this->json(['success' => true, 'message' => 'Permission updated.']);
    }
}
