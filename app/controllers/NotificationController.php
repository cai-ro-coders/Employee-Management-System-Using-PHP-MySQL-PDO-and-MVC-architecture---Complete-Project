<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function markRead(): void
    {
        $this->requireAuth();
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }
        (new Notification())->markAllRead(\Auth::id());
        $this->json(['success' => true, 'message' => 'All notifications marked read.']);
    }
}
