<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class LeaveApplication extends Model
{
    protected string $table = 'leave_applications';

    public function stats(): array
    {
        return [
            'applied'  => (int) Database::fetchColumn('SELECT COUNT(*) FROM leave_applications', [], 0),
            'approved' => (int) Database::fetchColumn('SELECT COUNT(*) FROM leave_applications WHERE status = "approved"', [], 0),
            'pending'  => (int) Database::fetchColumn('SELECT COUNT(*) FROM leave_applications WHERE status = "pending"', [], 0),
            'rejected' => (int) Database::fetchColumn('SELECT COUNT(*) FROM leave_applications WHERE status = "rejected"', [], 0),
        ];
    }

    public function recent(int $limit = 8): array
    {
        return Database::fetchAll(
            'SELECT la.*, u.first_name, u.last_name, u.avatar
             FROM leave_applications la
             JOIN employees e ON e.id = la.employee_id
             JOIN users u ON u.id = e.user_id
             ORDER BY la.created_at DESC LIMIT ' . $limit
        );
    }

    public function allWithDetails(): array
    {
        return Database::fetchAll(
            'SELECT la.*, u.first_name, u.last_name, u.avatar, e.employee_code,
                    r.first_name AS reviewer_first, r.last_name AS reviewer_last
             FROM leave_applications la
             JOIN employees e ON e.id = la.employee_id
             JOIN users u ON u.id = e.user_id
             LEFT JOIN users r ON r.id = la.reviewed_by
             ORDER BY la.created_at DESC'
        );
    }

    public function findWithDetails(int $id): ?array
    {
        return Database::fetchOne(
            'SELECT la.*, u.first_name, u.last_name, u.avatar, u.email, u.phone, e.employee_code,
                    e.designation, d.name AS department_name,
                    r.first_name AS reviewer_first, r.last_name AS reviewer_last
             FROM leave_applications la
             JOIN employees e ON e.id = la.employee_id
             JOIN users u ON u.id = e.user_id
             JOIN departments d ON d.id = e.department_id
             LEFT JOIN users r ON r.id = la.reviewed_by
             WHERE la.id = :id LIMIT 1',
            ['id' => $id]
        );
    }

    public function updateStatus(int $id, string $status, int $reviewerId, ?string $notes): int
    {
        return Database::update($this->table, [
            'status' => $status,
            'reviewed_by' => $reviewerId,
            'review_notes' => $notes,
        ], 'id = :id', ['id' => $id]);
    }
}