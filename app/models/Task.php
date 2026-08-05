<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Task extends Model
{
    protected string $table = 'tasks';

    public function allWithDetails(): array
    {
        return Database::fetchAll(
            'SELECT t.*,
                    ua.first_name AS assignee_first_name, ua.last_name AS assignee_last_name,
                    ub.first_name AS creator_first_name, ub.last_name AS creator_last_name
             FROM tasks t
             LEFT JOIN employees ea ON ea.id = t.assigned_to
             LEFT JOIN users ua ON ua.id = ea.user_id
             LEFT JOIN users ub ON ub.id = t.assigned_by
             ORDER BY FIELD(t.status, "todo", "in_progress", "done"), t.due_date ASC, t.id DESC'
        );
    }

    public function stats(): array
    {
        return [
            'todo'        => (int) Database::fetchColumn("SELECT COUNT(*) FROM tasks WHERE status = 'todo'", [], 0),
            'in_progress' => (int) Database::fetchColumn("SELECT COUNT(*) FROM tasks WHERE status = 'in_progress'", [], 0),
            'done'        => (int) Database::fetchColumn("SELECT COUNT(*) FROM tasks WHERE status = 'done'", [], 0),
            'overdue'     => (int) Database::fetchColumn("SELECT COUNT(*) FROM tasks WHERE due_date < CURDATE() AND status != 'done'", [], 0),
        ];
    }
}
