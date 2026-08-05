<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class ActivityLog extends Model
{
    protected string $table = 'activity_logs';

    public function recent(int $limit = 15): array
    {
        return Database::fetchAll(
            'SELECT al.*, u.first_name, u.last_name, u.avatar
             FROM activity_logs al
             LEFT JOIN users u ON u.id = al.user_id
             ORDER BY al.created_at DESC LIMIT ' . $limit
        );
    }

    public function paginated(int $page, int $perPage, ?string $search = null, ?string $module = null): array
    {
        $where = ['1=1'];
        $params = [];
        if ($search) {
            $where[] = '(al.description LIKE :s1 OR al.action LIKE :s2)';
            $params['s1'] = "%{$search}%";
            $params['s2'] = "%{$search}%";
        }
        if ($module) {
            $where[] = 'al.module = :module';
            $params['module'] = $module;
        }
        $whereSql = implode(' AND ', $where);
        $total = (int) Database::fetchColumn('SELECT COUNT(*) FROM activity_logs al WHERE ' . $whereSql, $params, 0);
        $offset = ($page - 1) * $perPage;
        $items = Database::fetchAll(
            'SELECT al.*, u.first_name, u.last_name FROM activity_logs al
             LEFT JOIN users u ON u.id = al.user_id
             WHERE ' . $whereSql . " ORDER BY al.created_at DESC LIMIT {$perPage} OFFSET {$offset}",
            $params
        );
        return ['items' => $items, 'total' => $total, 'page' => $page, 'pages' => (int) ceil($total / $perPage), 'perPage' => $perPage];
    }
}