<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Core\Session;
use App\Models\LeaveApplication;
use App\Models\Employee;
use Auth;

class LeaveController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('leave.review');
        $this->view('leaves/index', [
            'title'    => 'Leave Applications',
            'leaves'   => (new LeaveApplication())->allWithDetails(),
            'stats'    => (new LeaveApplication())->stats(),
            'employees'=> (new Employee())->searchableList(),
            'canApply' => \Auth::can('leave.apply'),
        ]);
    }

    public function store(): void
    {
        $this->requirePermission('leave.apply');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $employeeId = (int) Request::post('employee_id', 0);
        $type       = trim((string) Request::post('leave_type', ''));
        $startDate  = trim((string) Request::post('start_date', ''));
        $endDate    = trim((string) Request::post('end_date', ''));
        $reason     = trim((string) Request::post('reason', ''));

        $allowedTypes = ['sick', 'casual', 'annual', 'maternity', 'paternity', 'unpaid'];
        if (!in_array($type, $allowedTypes, true) || $startDate === '' || $endDate === '') {
            $this->json(['success' => false, 'message' => 'Leave type, start date and end date are required.'], 422);
        }
        if (strtotime($endDate) < strtotime($startDate)) {
            $this->json(['success' => false, 'message' => 'End date cannot be before start date.'], 422);
        }

        $emp = (new Employee())->find($employeeId);
        if (!$emp) {
            $this->json(['success' => false, 'message' => 'Invalid employee.'], 422);
        }

        $days = (int) ((strtotime($endDate) - strtotime($startDate)) / 86400) + 1;

        Database::insert('leave_applications', [
            'employee_id' => $employeeId,
            'leave_type'  => $type,
            'start_date'  => $startDate,
            'end_date'    => $endDate,
            'total_days'  => $days,
            'reason'      => $reason,
            'status'      => 'pending',
        ]);
        log_activity('create', 'leave_applications', "Submitted {$type} leave for employee #{$employeeId}");
        $this->json(['success' => true, 'message' => 'Leave application submitted.']);
    }

    public function show(int $id): void
    {
        $this->requirePermission('leave.review');
        $leave = (new LeaveApplication())->findWithDetails($id);
        if (!$leave) {
            $this->json(['success' => false, 'message' => 'Leave application not found.'], 404);
        }
        $this->json(['success' => true, 'data' => $leave]);
    }

    public function status(int $id): void
    {
        $this->requirePermission('leave.review');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $status = Request::post('status', '') === 'approved' ? 'approved' : 'rejected';
        $notes  = trim((string) Request::post('review_notes', ''));

        (new LeaveApplication())->updateStatus($id, $status, (int) Auth::id(), $notes);
        log_activity('update', 'leave_applications', ucfirst($status) . " leave #{$id}");
        $this->json(['success' => true, 'message' => 'Leave ' . $status . '.']);
    }

    public function delete(int $id): void
    {
        $this->requirePermission('leave.review');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        Database::delete('leave_applications', 'id = :id', ['id' => $id]);
        log_activity('delete', 'leave_applications', "Deleted leave #{$id}");
        $this->json(['success' => true, 'message' => 'Leave application deleted.']);
    }
}
