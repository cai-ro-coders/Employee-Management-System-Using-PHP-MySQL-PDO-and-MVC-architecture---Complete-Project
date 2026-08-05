<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Salary extends Model
{
    protected string $table = 'salaries';

    public function allWithDetails(): array
    {
        return Database::fetchAll(
            'SELECT s.*, u.first_name, u.last_name, u.avatar, e.employee_code, e.designation,
                    d.name AS department_name
             FROM salaries s
             JOIN employees e ON e.id = s.employee_id
             JOIN users u ON u.id = e.user_id
             JOIN departments d ON d.id = e.department_id
             ORDER BY u.first_name ASC, u.last_name ASC'
        );
    }

    public function existsForEmployee(int $employeeId): bool
    {
        return (bool) Database::fetchColumn('SELECT COUNT(*) FROM salaries WHERE employee_id = :id', ['id' => $employeeId], 0);
    }
}
