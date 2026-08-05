<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Payslip extends Model
{
    protected string $table = 'payslips';

    public function forMonth(int $month, int $year): array
    {
        return Database::fetchAll(
            'SELECT p.*, u.first_name, u.last_name, u.avatar, e.employee_code, e.designation,
                    d.name AS department_name
             FROM payslips p
             JOIN employees e ON e.id = p.employee_id
             JOIN users u ON u.id = e.user_id
             JOIN departments d ON d.id = e.department_id
             WHERE p.month = :month AND p.year = :year
             ORDER BY p.payslip_number ASC',
            ['month' => $month, 'year' => $year]
        );
    }

    public function monthStats(int $month, int $year): array
    {
        return Database::fetchOne(
            'SELECT COUNT(*) AS total,
                    COALESCE(SUM(net_salary), 0) AS net_total,
                    COALESCE(SUM(CASE WHEN payment_status = "paid" THEN 1 ELSE 0 END), 0) AS paid,
                    COALESCE(SUM(CASE WHEN payment_status = "unpaid" THEN 1 ELSE 0 END), 0) AS unpaid,
                    COALESCE(SUM(CASE WHEN payment_status = "partial" THEN 1 ELSE 0 END), 0) AS partial
             FROM payslips
             WHERE month = :month AND year = :year',
            ['month' => $month, 'year' => $year]
        ) ?? ['total' => 0, 'net_total' => 0, 'paid' => 0, 'unpaid' => 0, 'partial' => 0];
    }

    public function existsFor(int $employeeId, int $month, int $year): bool
    {
        return (bool) Database::fetchColumn(
            'SELECT COUNT(*) FROM payslips WHERE employee_id = :e AND month = :m AND year = :y',
            ['e' => $employeeId, 'm' => $month, 'y' => $year],
            0
        );
    }

    public function nextNumber(int $year): string
    {
        $seq = (int) Database::fetchColumn(
            "SELECT MAX(CAST(SUBSTRING_INDEX(payslip_number, '-', -1) AS UNSIGNED))
             FROM payslips WHERE payslip_number LIKE :prefix",
            ['prefix' => 'PS' . $year . '-%'],
            0
        ) + 1;
        return 'PS' . $year . '-' . str_pad((string) $seq, 4, '0', STR_PAD_LEFT);
    }
}
