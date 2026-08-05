<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Models\Payslip;
use App\Models\Salary;

class PayslipController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('payroll.view');
        $month = (int) Request::query('month', (int) date('n'));
        $year  = (int) Request::query('year', (int) date('Y'));
        if ($month < 1 || $month > 12) {
            $month = (int) date('n');
        }
        if ($year < 2000 || $year > 2100) {
            $year = (int) date('Y');
        }

        $this->view('payslips/index', [
            'title'    => 'Generate Payslips',
            'payslips' => (new Payslip())->forMonth($month, $year),
            'stats'    => (new Payslip())->monthStats($month, $year),
            'month'    => $month,
            'year'     => $year,
            'canEdit'  => \Auth::can('payroll.generate'),
        ]);
    }

    public function generate(): void
    {
        $this->requirePermission('payroll.generate');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $month = (int) Request::post('month', 0);
        $year  = (int) Request::post('year', 0);
        if ($month < 1 || $month > 12 || $year < 2000 || $year > 2100) {
            $this->json(['success' => false, 'message' => 'Invalid month or year.'], 422);
        }

        $payslip = new Payslip();
        $created = 0;
        foreach ((new Salary())->allWithDetails() as $s) {
            $employeeId = (int) $s['employee_id'];
            if ($payslip->existsFor($employeeId, $month, $year)) {
                continue;
            }

            $basic       = (float) $s['basic_salary'];
            $allowances  = $s['house_rent_allowance'] + $s['medical_allowance'] + $s['other_allowances'];
            $pf          = round($basic * (float) $s['pf_deduction_rate'] / 100, 2);
            $deductions  = round($pf + (float) $s['tax_deduction'], 2);

            Database::insert('payslips', [
                'employee_id'      => $employeeId,
                'payslip_number'   => $payslip->nextNumber($year),
                'month'            => $month,
                'year'             => $year,
                'basic_salary'     => $basic,
                'total_allowances' => $allowances,
                'total_deductions' => $deductions,
                'pf_amount'        => $pf,
                'net_salary'       => round($basic + $allowances - $deductions, 2),
                'payment_status'   => 'unpaid',
            ]);
            $created++;
        }

        $label = date('F Y', mktime(0, 0, 0, $month, 1, $year));
        if ($created === 0) {
            $this->json(['success' => false, 'message' => 'No new payslips to generate — every employee with a salary structure already has one for ' . $label . '.'], 422);
        }

        log_activity('create', 'payslips', "Generated {$created} payslips for {$label}");
        $this->json(['success' => true, 'message' => "{$created} payslip(s) generated for {$label}."]);
    }

    public function update(int $id): void
    {
        $this->requirePermission('payroll.generate');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $status = Request::post('payment_status', '');
        if (!in_array($status, ['paid', 'unpaid', 'partial'], true)) {
            $this->json(['success' => false, 'message' => 'Invalid payment status.'], 422);
        }

        Database::update('payslips', [
            'payment_status' => $status,
            'payment_date'   => $status === 'paid' ? date('Y-m-d') : null,
        ], 'id = :id', ['id' => $id]);

        log_activity('update', 'payslips', "Marked payslip #{$id} as {$status}");
        $this->json(['success' => true, 'message' => 'Payslip updated.']);
    }

    public function delete(int $id): void
    {
        $this->requirePermission('payroll.generate');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        Database::delete('payslips', 'id = :id', ['id' => $id]);
        log_activity('delete', 'payslips', "Deleted payslip #{$id}");
        $this->json(['success' => true, 'message' => 'Payslip deleted.']);
    }
}
