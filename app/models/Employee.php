<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Employee extends Model
{
    protected string $table = 'employees';

    public function withDetails(int $id): ?array
    {
        return Database::fetchOne(
            'SELECT e.*, u.first_name, u.last_name, u.email, u.phone, u.username, u.avatar, u.address, u.status AS user_status,
                    d.name AS department_name, d.code AS department_code
             FROM employees e
             JOIN users u ON u.id = e.user_id
             JOIN departments d ON d.id = e.department_id
             WHERE e.id = :id',
            ['id' => $id]
        );
    }

    public function searchableList(?string $search = null, ?int $departmentId = null): array
    {
        $where = ['1=1'];
        $params = [];
        if ($search) {
            $where[] = '(e.employee_code LIKE :s1 OR u.first_name LIKE :s2 OR u.last_name LIKE :s3 OR e.designation LIKE :s4)';
            $params['s1'] = "%{$search}%";
            $params['s2'] = "%{$search}%";
            $params['s3'] = "%{$search}%";
            $params['s4'] = "%{$search}%";
        }
        if ($departmentId) {
            $where[] = 'e.department_id = :dept';
            $params['dept'] = $departmentId;
        }
        return Database::fetchAll(
            'SELECT e.*, u.first_name, u.last_name, u.email, u.avatar, u.status AS user_status,
                    d.name AS department_name
             FROM employees e
             JOIN users u ON u.id = e.user_id
             JOIN departments d ON d.id = e.department_id
             WHERE ' . implode(' AND ', $where) . '
             ORDER BY e.id DESC',
            $params
        );
    }

    public function findByUserId(int $userId): ?array
    {
        return Database::fetchOne('SELECT * FROM employees WHERE user_id = :id', ['id' => $userId]);
    }

    public function bankDetails(int $employeeId): ?array
    {
        return Database::fetchOne('SELECT * FROM employee_bank_details WHERE employee_id = :id', ['id' => $employeeId]);
    }

    public function documents(int $employeeId): array
    {
        return Database::fetchAll('SELECT * FROM employee_documents WHERE employee_id = :id ORDER BY uploaded_at DESC', ['id' => $employeeId]);
    }

    public function attendance(int $employeeId, int $limit = 10): array
    {
        return Database::fetchAll(
            'SELECT * FROM attendance WHERE employee_id = :id ORDER BY date DESC LIMIT ' . $limit,
            ['id' => $employeeId]
        );
    }

    public function countByDepartment(): array
    {
        return Database::fetchAll(
            'SELECT d.name, COUNT(e.id) AS total FROM departments d
             LEFT JOIN employees e ON e.department_id = d.id
             GROUP BY d.id, d.name ORDER BY total DESC'
        );
    }

    public function onLeaveToday(): array
    {
        return Database::fetchAll(
            'SELECT e.employee_code, u.first_name, u.last_name, la.leave_type
             FROM leave_applications la
             JOIN employees e ON e.id = la.employee_id
             JOIN users u ON u.id = e.user_id
             WHERE la.status = "approved"
               AND :today BETWEEN la.start_date AND la.end_date',
            ['today' => date('Y-m-d')]
        );
    }

    public function monthlySalaryTotal(): float
    {
        return (float) Database::fetchColumn('SELECT COALESCE(SUM(salary), 0) FROM employees', [], 0);
    }
}