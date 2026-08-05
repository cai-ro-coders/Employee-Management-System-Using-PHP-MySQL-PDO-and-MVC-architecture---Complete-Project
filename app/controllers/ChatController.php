<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Chat;

class ChatController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        $this->view('chat/index', [
            'title'    => 'Internal Chat',
            'contacts' => (new Chat())->contacts((int) \Auth::id()),
            'myId'     => (int) \Auth::id(),
        ]);
    }

    public function contacts(): void
    {
        $this->requireAuth();
        $this->json(['success' => true, 'contacts' => (new Chat())->contacts((int) \Auth::id())]);
    }

    public function messages(int $userId): void
    {
        $this->requireAuth();
        $me = (int) \Auth::id();
        if ($userId === $me || $userId <= 0) {
            $this->json(['success' => false, 'message' => 'Invalid conversation.'], 422);
        }

        $chat = new Chat();
        $this->json([
            'success'  => true,
            'messages' => $chat->conversation($me, $userId),
            'unread'   => $chat->markRead($userId, $me),
        ]);
    }

    public function send(): void
    {
        $this->requireAuth();
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $me         = (int) \Auth::id();
        $receiverId = (int) Request::post('receiver_id', 0);
        $message    = trim((string) Request::post('message', ''));

        if ($receiverId <= 0 || $receiverId === $me) {
            $this->json(['success' => false, 'message' => 'Select a valid recipient.'], 422);
        }
        if ($message === '') {
            $this->json(['success' => false, 'message' => 'Message cannot be empty.'], 422);
        }

        $row = (new Chat())->send($me, $receiverId, $message);
        log_activity('create', 'chat', 'Sent a chat message');
        $this->json(['success' => true, 'message' => 'Message sent.', 'row' => $row]);
    }
}
