<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class User extends Model
{
    protected string $table = 'users';

    public function findByEmailOrUsername(string $identifier): ?array
    {
        return Database::fetchOne(
            'SELECT * FROM users WHERE email = :id1 OR username = :id2 LIMIT 1',
            ['id1' => $identifier, 'id2' => $identifier]
        );
    }

    public function withRole(int $id): ?array
    {
        return Database::fetchOne(
            'SELECT u.*, r.name AS role_name FROM users u JOIN roles r ON r.id = u.role_id WHERE u.id = :id',
            ['id' => $id]
        );
    }

    public function allWithRole(string $orderBy = 'u.id DESC'): array
    {
        return Database::fetchAll(
            "SELECT u.*, r.name AS role_name FROM users u JOIN roles r ON r.id = u.role_id
             ORDER BY {$orderBy}"
        );
    }

    public function recentLoginHistory(int $userId, int $limit = 10): array
    {
        return Database::fetchAll(
            'SELECT * FROM login_history WHERE user_id = :id ORDER BY login_at DESC LIMIT ' . $limit,
            ['id' => $userId]
        );
    }

    public function loginHistoryAll(int $page, int $perPage, ?string $search = null): array
    {
        $where = '';
        $params = [];
        if ($search) {
            $where = 'WHERE lh.user_agent LIKE :s1 OR u.email LIKE :s2';
            $params['s1'] = "%{$search}%";
            $params['s2'] = "%{$search}%";
        }
        $total = (int) Database::fetchColumn(
            'SELECT COUNT(*) FROM login_history lh LEFT JOIN users u ON u.id = lh.user_id ' . $where,
            $params, 0
        );
        $offset = ($page - 1) * $perPage;
        $items = Database::fetchAll(
            'SELECT lh.*, u.email AS user_email FROM login_history lh LEFT JOIN users u ON u.id = lh.user_id ' . $where .
            " ORDER BY lh.login_at DESC LIMIT {$perPage} OFFSET {$offset}",
            $params
        );
        return ['items' => $items, 'total' => $total, 'page' => $page, 'pages' => (int) ceil($total / $perPage), 'perPage' => $perPage];
    }
}