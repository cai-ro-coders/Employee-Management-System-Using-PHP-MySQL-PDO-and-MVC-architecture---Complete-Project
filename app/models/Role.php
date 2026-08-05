<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Role extends Model
{
    protected string $table = 'roles';

    public function permissions(int $roleId): array
    {
        return Database::fetchAll(
            'SELECT p.* FROM permissions p
             JOIN role_permissions rp ON rp.permission_id = p.id
             WHERE rp.role_id = :roleId
             ORDER BY p.module_name, p.action_name',
            ['roleId' => $roleId]
        );
    }

    public function allPermissions(): array
    {
        return Database::fetchAll('SELECT * FROM permissions ORDER BY module_name, action_name');
    }

    public function assignPermissions(int $roleId, array $permissionIds): void
    {
        Database::delete('role_permissions', 'role_id = :roleId', ['roleId' => $roleId]);
        foreach ($permissionIds as $permissionId) {
            Database::insert('role_permissions', [
                'role_id' => $roleId, 'permission_id' => (int) $permissionId,
            ]);
        }
    }

    public function usersCount(int $roleId): int
    {
        return (int) Database::fetchColumn('SELECT COUNT(*) FROM users WHERE role_id = :roleId', ['roleId' => $roleId], 0);
    }
}