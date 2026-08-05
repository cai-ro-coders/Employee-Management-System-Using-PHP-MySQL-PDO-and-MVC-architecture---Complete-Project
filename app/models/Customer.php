<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Customer extends Model
{
    protected string $table = 'customers';

    public function searchableList(?string $search = null, ?string $status = null, ?string $type = null): array
    {
        $where = ['c.deleted_at IS NULL'];
        $params = [];
        if ($search) {
            $where[] = '(c.first_name LIKE :s1 OR c.last_name LIKE :s2 OR c.company LIKE :s3 OR c.email LIKE :s4)';
            $params['s1'] = "%{$search}%";
            $params['s2'] = "%{$search}%";
            $params['s3'] = "%{$search}%";
            $params['s4'] = "%{$search}%";
        }
        if ($status) {
            $where[] = 'c.status = :status';
            $params['status'] = $status;
        }
        if ($type) {
            $where[] = 'c.customer_type = :type';
            $params['type'] = $type;
        }
        return Database::fetchAll(
            'SELECT c.*, (SELECT COUNT(*) FROM customer_notes n WHERE n.customer_id = c.id) AS note_count
             FROM customers c
             WHERE ' . implode(' AND ', $where) . '
             ORDER BY c.id DESC',
            $params
        );
    }

    public function softDelete(int $id): int
    {
        return Database::update($this->table, ['deleted_at' => date('Y-m-d H:i:s')], 'id = :id', ['id' => $id]);
    }

    public function notes(int $customerId): array
    {
        return Database::fetchAll(
            'SELECT cn.*, u.first_name, u.last_name FROM customer_notes cn
             LEFT JOIN users u ON u.id = cn.user_id
             WHERE cn.customer_id = :id ORDER BY cn.created_at DESC',
            ['id' => $customerId]
        );
    }

    public function addNote(int $customerId, int $userId, string $note): int
    {
        return Database::insert('customer_notes', [
            'customer_id' => $customerId, 'user_id' => $userId, 'note' => $note,
        ]);
    }

    public function documents(int $customerId): array
    {
        return Database::fetchAll('SELECT * FROM customer_documents WHERE customer_id = :id ORDER BY created_at DESC', ['id' => $customerId]);
    }

    public function tags(int $customerId): array
    {
        return Database::fetchAll(
            'SELECT t.* FROM customer_tags t
             JOIN customer_tag ct ON ct.tag_id = t.id
             WHERE ct.customer_id = :id',
            ['id' => $customerId]
        );
    }

    public function allTags(): array
    {
        return Database::fetchAll('SELECT * FROM customer_tags ORDER BY name');
    }

    public function countByStatus(): array
    {
        return [
            'active'   => (int) Database::fetchColumn('SELECT COUNT(*) FROM customers WHERE status = "active" AND deleted_at IS NULL', [], 0),
            'inactive' => (int) Database::fetchColumn('SELECT COUNT(*) FROM customers WHERE status = "inactive" AND deleted_at IS NULL', [], 0),
        ];
    }
}