<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Notice extends Model
{
    protected string $table = 'notices';

    public function allWithDetails(): array
    {
        return Database::fetchAll(
            'SELECT n.*,
                    u.first_name, u.last_name,
                    r.name AS target_role_name
             FROM notices n
             LEFT JOIN users u ON u.id = n.posted_by
             LEFT JOIN roles r ON r.id = n.target_role_id
             ORDER BY n.created_at DESC, n.id DESC'
        );
    }

    public function roles(): array
    {
        return Database::fetchAll('SELECT id, name FROM roles ORDER BY id ASC');
    }
}
