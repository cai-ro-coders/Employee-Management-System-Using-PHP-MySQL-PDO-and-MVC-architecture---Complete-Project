<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Notification extends Model
{
    protected string $table = 'notifications';

    public function unreadFor(int $userId): int
    {
        return (int) Database::fetchColumn(
            'SELECT COUNT(*) FROM notifications WHERE user_id = :id AND is_read = 0',
            ['id' => $userId], 0
        );
    }

    public function recentFor(int $userId, int $limit = 8): array
    {
        return Database::fetchAll(
            'SELECT * FROM notifications WHERE user_id = :id ORDER BY created_at DESC LIMIT ' . $limit,
            ['id' => $userId]
        );
    }

    public function markAllRead(int $userId): int
    {
        return Database::update($this->table, ['is_read' => 1], 'user_id = :id', ['id' => $userId]);
    }

    public function push(int $userId, string $title, string $message, string $type = 'info'): int
    {
        return Database::insert('notifications', [
            'user_id' => $userId, 'title' => $title, 'message' => $message, 'type' => $type,
        ]);
    }
}