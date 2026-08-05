<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Expense extends Model
{
    protected string $table = 'expenses';

    public function allWithDetails(): array
    {
        return Database::fetchAll(
            'SELECT e.*, u.first_name, u.last_name
             FROM expenses e
             LEFT JOIN users u ON u.id = e.purchased_by
             ORDER BY e.expense_date DESC, e.id DESC'
        );
    }

    public function stats(): array
    {
        $total    = (float) Database::fetchColumn('SELECT COALESCE(SUM(amount), 0) FROM expenses', [], 0);
        $pending  = (int) Database::fetchColumn("SELECT COUNT(*) FROM expenses WHERE status = 'pending'", [], 0);
        $approved = (int) Database::fetchColumn("SELECT COUNT(*) FROM expenses WHERE status = 'approved'", [], 0);
        $rejected = (int) Database::fetchColumn("SELECT COUNT(*) FROM expenses WHERE status = 'rejected'", [], 0);
        return [
            'total'    => $total,
            'pending'  => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
        ];
    }

    public function users(): array
    {
        return Database::fetchAll(
            'SELECT id, first_name, last_name FROM users ORDER BY first_name ASC, last_name ASC'
        );
    }
}
