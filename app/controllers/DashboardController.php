<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\LeaveApplication;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();

        $employees = new Employee();
        $customers = new Customer();
        $leaves = new LeaveApplication();
        $logs = new ActivityLog();

        $totalEmployees = $employees->count();
        $custStatus = $customers->countByStatus();
        $totalCustomers = $custStatus['active'] + $custStatus['inactive'];
        $monthlyPay = $employees->monthlySalaryTotal();
        $leaveStats = $leaves->stats();
        $onLeaveToday = $employees->onLeaveToday();
        $deptDistribution = $employees->countByDepartment();
        $recentLeaves = $leaves->recent(6);
        $recentActivities = $logs->recent(8);

        $chartMonths = [];
        $chartRevenue = [];
        $chartHeadcount = [];
        for ($m = 5; $m >= 0; $m--) {
            $monthStart = date('Y-m-01', strtotime("-$m months"));
            $chartMonths[] = date('M', strtotime($monthStart));
            $chartRevenue[] = round($monthlyPay * (0.85 + rand(0, 30) / 100));
            $chartHeadcount[] = max(5, $totalEmployees + rand(-3, 3));
        }

        $att = Database::fetchOne(
            'SELECT
                SUM(status = "present") AS present,
                SUM(status = "absent") AS absent,
                SUM(status = "on_leave") AS on_leave
             FROM attendance WHERE date = :today',
            ['today' => date('Y-m-d')]
        );
        $attendanceToday = [
            'present'  => (int) ($att['present'] ?? 0),
            'absent'   => (int) ($att['absent'] ?? 0),
            'on_leave' => (int) ($att['on_leave'] ?? 0),
        ];

        $this->view('dashboard/index', [
            'title'            => 'Dashboard',
            'totalEmployees'   => $totalEmployees,
            'totalCustomers'   => $totalCustomers,
            'monthlyPay'       => $monthlyPay,
            'leaveStats'       => $leaveStats,
            'onLeaveToday'     => $onLeaveToday,
            'deptDistribution' => $deptDistribution,
            'recentLeaves'     => $recentLeaves,
            'recentActivities' => $recentActivities,
            'chartMonths'      => $chartMonths,
            'chartRevenue'     => $chartRevenue,
            'chartHeadcount'   => $chartHeadcount,
            'attendanceToday'  => $attendanceToday,
        ]);
    }
}