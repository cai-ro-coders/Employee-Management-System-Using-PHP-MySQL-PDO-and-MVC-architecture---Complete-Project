<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Chat extends Model
{
    protected string $table = 'chat_messages';

    public function contacts(int $userId): array
    {
        return Database::fetchAll(
            'SELECT u.id, u.first_name, u.last_name, u.avatar, u.status,
                    r.name AS role_name,
                    (SELECT cm.message FROM chat_messages cm
                     WHERE (cm.sender_id = u.id AND cm.receiver_id = :uid1)
                        OR (cm.sender_id = :uid2 AND cm.receiver_id = u.id)
                     ORDER BY cm.id DESC LIMIT 1) AS last_message,
                    (SELECT cm.created_at FROM chat_messages cm
                     WHERE (cm.sender_id = u.id AND cm.receiver_id = :uid3)
                        OR (cm.sender_id = :uid4 AND cm.receiver_id = u.id)
                     ORDER BY cm.id DESC LIMIT 1) AS last_at,
                    (SELECT COUNT(*) FROM chat_messages cm
                     WHERE cm.sender_id = u.id AND cm.receiver_id = :uid5 AND cm.is_read = 0) AS unread
             FROM users u
             JOIN roles r ON r.id = u.role_id
             WHERE u.id <> :uid6 AND u.status = :active
             ORDER BY unread DESC, last_at IS NULL ASC, last_at DESC, u.first_name ASC',
            [
                'uid1' => $userId, 'uid2' => $userId, 'uid3' => $userId,
                'uid4' => $userId, 'uid5' => $userId, 'uid6' => $userId,
                'active' => 'active',
            ]
        );
    }

    public function conversation(int $a, int $b): array
    {
        return Database::fetchAll(
            'SELECT cm.*, u.first_name, u.last_name, u.avatar AS sender_avatar
             FROM chat_messages cm
             JOIN users u ON u.id = cm.sender_id
             WHERE (cm.sender_id = :a1 AND cm.receiver_id = :b1)
                OR (cm.sender_id = :b2 AND cm.receiver_id = :a2)
             ORDER BY cm.id ASC',
            ['a1' => $a, 'b1' => $b, 'b2' => $b, 'a2' => $a]
        );
    }

    public function send(int $senderId, int $receiverId, string $message): array
    {
        $id = Database::insert('chat_messages', [
            'sender_id'   => $senderId,
            'receiver_id' => $receiverId,
            'message'     => $message,
            'is_read'     => 0,
        ]);
        $row = Database::fetchOne(
            'SELECT * FROM chat_messages WHERE id = :id',
            ['id' => $id]
        );
        return $row ?? ['id' => $id, 'message' => $message];
    }

    public function markRead(int $senderId, int $receiverId): int
    {
        return Database::update(
            'chat_messages',
            ['is_read' => 1],
            'sender_id = :sender AND receiver_id = :receiver AND is_read = 0',
            ['sender' => $senderId, 'receiver' => $receiverId]
        );
    }

    public function unreadTotal(int $userId): int
    {
        return (int) Database::fetchColumn(
            'SELECT COUNT(*) FROM chat_messages WHERE receiver_id = :id AND is_read = 0',
            ['id' => $userId],
            0
        );
    }
}
