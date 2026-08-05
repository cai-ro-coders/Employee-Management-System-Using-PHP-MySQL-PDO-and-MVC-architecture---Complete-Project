<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Models\Task;
use App\Models\Employee;

class TaskController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('tasks.manage');
        $model = new Task();
        $this->view('tasks/index', [
            'title'    => 'Task Board',
            'tasks'    => $model->allWithDetails(),
            'stats'    => $model->stats(),
            'employees'=> (new Employee())->searchableList(),
        ]);
    }

    public function store(): void
    {
        $this->requirePermission('tasks.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $data = $this->taskPayload();
        if ($data['title'] === '') {
            $this->json(['success' => false, 'message' => 'Task title is required.'], 422);
        }

        $data['assigned_by'] = \Auth::id();
        Database::insert('tasks', $data);
        log_activity('create', 'tasks', "Created task {$data['title']}");
        $this->json(['success' => true, 'message' => 'Task created.']);
    }

    public function update(int $id): void
    {
        $this->requirePermission('tasks.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $data = $this->taskPayload();
        if ($data['title'] === '') {
            $this->json(['success' => false, 'message' => 'Task title is required.'], 422);
        }

        Database::update('tasks', $data, 'id = :id', ['id' => $id]);
        log_activity('update', 'tasks', "Updated task #{$id}");
        $this->json(['success' => true, 'message' => 'Task updated.']);
    }

    public function status(int $id): void
    {
        $this->requirePermission('tasks.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $status = Request::post('status', 'todo');
        if (!in_array($status, ['todo', 'in_progress', 'done'], true)) {
            $this->json(['success' => false, 'message' => 'Invalid status.'], 422);
        }

        Database::update('tasks', ['status' => $status], 'id = :id', ['id' => $id]);
        log_activity('update', 'tasks', "Moved task #{$id} to {$status}");
        $this->json(['success' => true, 'message' => 'Task moved to ' . str_replace('_', ' ', $status) . '.']);
    }

    public function delete(int $id): void
    {
        $this->requirePermission('tasks.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        Database::delete('tasks', 'id = :id', ['id' => $id]);
        log_activity('delete', 'tasks', "Deleted task #{$id}");
        $this->json(['success' => true, 'message' => 'Task deleted.']);
    }

    protected function taskPayload(): array
    {
        $assignedTo = (int) Request::post('assigned_to', 0);
        return [
            'title'       => trim((string) Request::post('title', '')),
            'description' => trim((string) Request::post('description', '')),
            'assigned_to' => $assignedTo > 0 ? $assignedTo : null,
            'due_date'    => trim((string) Request::post('due_date', '')) ?: null,
            'priority'    => in_array(Request::post('priority', 'medium'), ['low', 'medium', 'high', 'urgent'], true)
                ? Request::post('priority', 'medium') : 'medium',
            'status'      => in_array(Request::post('status', 'todo'), ['todo', 'in_progress', 'done'], true)
                ? Request::post('status', 'todo') : 'todo',
        ];
    }
}
