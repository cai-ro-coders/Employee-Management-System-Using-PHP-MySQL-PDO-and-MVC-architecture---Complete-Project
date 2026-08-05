<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Models\Salary;
use App\Models\Employee;

class SalaryController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('payroll.view');
        $salaries = (new Salary())->allWithDetails();
        $this->view('salaries/index', [
            'title'        => 'Salary Structure',
            'salaries'     => $salaries,
            'employees'    => (new Employee())->searchableList(),
            'structureIds' => array_flip(array_column($salaries, 'employee_id')),
            'canEdit'      => \Auth::can('payroll.generate'),
        ]);
    }

    public function store(): void
    {
        $this->requirePermission('payroll.generate');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $employeeId = (int) Request::post('employee_id', 0);
        $basic      = (float) Request::post('basic_salary', 0);

        if ($employeeId <= 0 || $basic <= 0) {
            $this->json(['success' => false, 'message' => 'Employee and basic salary are required.'], 422);
        }
        if ((new Salary())->existsForEmployee($employeeId)) {
            $this->json(['success' => false, 'message' => 'A salary structure already exists for this employee.'], 422);
        }

        Database::insert('salaries', $this->salaryPayload($employeeId, $basic));
        log_activity('create', 'salaries', "Created salary structure for employee #{$employeeId}");
        $this->json(['success' => true, 'message' => 'Salary structure created.']);
    }

    public function update(int $id): void
    {
        $this->requirePermission('payroll.generate');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $basic = (float) Request::post('basic_salary', 0);
        if ($basic <= 0) {
            $this->json(['success' => false, 'message' => 'Basic salary is required.'], 422);
        }

        Database::update('salaries', $this->salaryPayload(0, $basic), 'id = :id', ['id' => $id]);
        log_activity('update', 'salaries', "Updated salary structure #{$id}");
        $this->json(['success' => true, 'message' => 'Salary structure updated.']);
    }

    public function delete(int $id): void
    {
        $this->requirePermission('payroll.generate');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        Database::delete('salaries', 'id = :id', ['id' => $id]);
        log_activity('delete', 'salaries', "Deleted salary structure #{$id}");
        $this->json(['success' => true, 'message' => 'Salary structure deleted.']);
    }

    protected function salaryPayload(int $employeeId, float $basic): array
    {
        $data = [
            'basic_salary'         => $basic,
            'house_rent_allowance' => (float) Request::post('house_rent_allowance', 0),
            'medical_allowance'    => (float) Request::post('medical_allowance', 0),
            'other_allowances'     => (float) Request::post('other_allowances', 0),
            'pf_deduction_rate'    => (float) Request::post('pf_deduction_rate', 12),
            'tax_deduction'        => (float) Request::post('tax_deduction', 0),
        ];
        if ($employeeId > 0) {
            $data['employee_id'] = $employeeId;
        }
        return $data;
    }
}
