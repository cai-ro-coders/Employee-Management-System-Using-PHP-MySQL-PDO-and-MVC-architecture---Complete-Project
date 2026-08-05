<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Core\Session;
use App\Models\Holiday;

class HolidayController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('holidays.manage');
        $this->view('holidays/index', [
            'title'    => 'Company Holidays',
            'holidays' => (new Holiday())->allSorted(),
        ]);
    }

    public function store(): void
    {
        $this->requirePermission('holidays.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $name      = trim((string) Request::post('event_name', ''));
        $startDate = trim((string) Request::post('start_date', ''));
        $endDate   = trim((string) Request::post('end_date', ''));

        if ($name === '' || $startDate === '') {
            $this->json(['success' => false, 'message' => 'Holiday name and start date are required.'], 422);
        }
        if ($endDate !== '' && strtotime($endDate) < strtotime($startDate)) {
            $this->json(['success' => false, 'message' => 'End date cannot be before start date.'], 422);
        }

        Database::insert('holidays', [
            'event_name'  => $name,
            'start_date'  => $startDate,
            'end_date'    => $endDate !== '' ? $endDate : $startDate,
            'description' => trim((string) Request::post('description', '')),
        ]);
        log_activity('create', 'holidays', "Created holiday {$name}");
        $this->json(['success' => true, 'message' => 'Holiday created.']);
    }

    public function update(int $id): void
    {
        $this->requirePermission('holidays.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $name      = trim((string) Request::post('event_name', ''));
        $startDate = trim((string) Request::post('start_date', ''));
        $endDate   = trim((string) Request::post('end_date', ''));

        if ($name === '' || $startDate === '') {
            $this->json(['success' => false, 'message' => 'Holiday name and start date are required.'], 422);
        }
        if ($endDate !== '' && strtotime($endDate) < strtotime($startDate)) {
            $this->json(['success' => false, 'message' => 'End date cannot be before start date.'], 422);
        }

        Database::update('holidays', [
            'event_name'  => $name,
            'start_date'  => $startDate,
            'end_date'    => $endDate !== '' ? $endDate : $startDate,
            'description' => trim((string) Request::post('description', '')),
        ], 'id = :id', ['id' => $id]);

        log_activity('update', 'holidays', "Updated holiday {$name}");
        $this->json(['success' => true, 'message' => 'Holiday updated.']);
    }

    public function delete(int $id): void
    {
        $this->requirePermission('holidays.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        Database::delete('holidays', 'id = :id', ['id' => $id]);
        log_activity('delete', 'holidays', "Deleted holiday #{$id}");
        $this->json(['success' => true, 'message' => 'Holiday deleted.']);
    }
}
