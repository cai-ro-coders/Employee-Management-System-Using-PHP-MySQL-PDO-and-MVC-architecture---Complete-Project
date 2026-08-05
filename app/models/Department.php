<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Department extends Model
{
    protected string $table = 'departments';

    public function allActive(): array
    {
        return Database::fetchAll('SELECT * FROM departments WHERE status = "active" ORDER BY name');
    }

    public function withEmployeeCount(): array
    {
        return Database::fetchAll(
            'SELECT d.*, COUNT(e.id) AS employee_count
             FROM departments d
             LEFT JOIN employees e ON e.department_id = d.id
             GROUP BY d.id, d.name, d.code, d.status, d.created_at, d.updated_at
             ORDER BY d.name'
        );
    }
}