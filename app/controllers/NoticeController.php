<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Models\Notice;

class NoticeController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('notices.manage');
        $model = new Notice();
        $this->view('notices/index', [
            'title'   => 'Notice Board',
            'notices' => $model->allWithDetails(),
            'roles'   => $model->roles(),
        ]);
    }

    public function store(): void
    {
        $this->requirePermission('notices.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $data = $this->noticePayload();
        if ($data['title'] === '' || $data['content'] === '') {
            $this->json(['success' => false, 'message' => 'Title and content are required.'], 422);
        }

        $data['posted_by'] = \Auth::id();
        Database::insert('notices', $data);
        log_activity('create', 'notices', "Posted notice {$data['title']}");
        $this->json(['success' => true, 'message' => 'Notice posted.']);
    }

    public function update(int $id): void
    {
        $this->requirePermission('notices.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $data = $this->noticePayload();
        if ($data['title'] === '' || $data['content'] === '') {
            $this->json(['success' => false, 'message' => 'Title and content are required.'], 422);
        }

        Database::update('notices', $data, 'id = :id', ['id' => $id]);
        log_activity('update', 'notices', "Updated notice #{$id}");
        $this->json(['success' => true, 'message' => 'Notice updated.']);
    }

    public function delete(int $id): void
    {
        $this->requirePermission('notices.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        Database::delete('notices', 'id = :id', ['id' => $id]);
        log_activity('delete', 'notices', "Deleted notice #{$id}");
        $this->json(['success' => true, 'message' => 'Notice deleted.']);
    }

    protected function noticePayload(): array
    {
        $targetRole = (int) Request::post('target_role_id', 0);
        return [
            'title'          => trim((string) Request::post('title', '')),
            'content'        => trim((string) Request::post('content', '')),
            'target_role_id' => $targetRole > 0 ? $targetRole : null,
        ];
    }
}
