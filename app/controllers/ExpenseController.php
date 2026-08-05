<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Models\Expense;
use \Upload as Uploader;

class ExpenseController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('expenses.manage');
        $model = new Expense();
        $this->view('expenses/index', [
            'title'   => 'Company Expenses',
            'expenses'=> $model->allWithDetails(),
            'stats'   => $model->stats(),
            'users'   => $model->users(),
        ]);
    }

    public function store(): void
    {
        $this->requirePermission('expenses.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $data = $this->expensePayload();
        if ($data['title'] === '' || $data['expense_date'] === '') {
            $this->json(['success' => false, 'message' => 'Title, amount and expense date are required.'], 422);
        }
        if ($data['amount'] <= 0) {
            $this->json(['success' => false, 'message' => 'Amount must be greater than zero.'], 422);
        }

        if (isset($_FILES['receipt_file']) && $_FILES['receipt_file']['error'] === UPLOAD_ERR_OK) {
            try {
                $data['receipt_file'] = Uploader::store($_FILES['receipt_file'], 'expenses');
            } catch (\Throwable $e) {
                $this->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
        }

        Database::insert('expenses', $data);
        log_activity('create', 'expenses', "Created expense {$data['title']}");
        $this->json(['success' => true, 'message' => 'Expense created.']);
    }

    public function update(int $id): void
    {
        $this->requirePermission('expenses.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $data = $this->expensePayload();
        if ($data['title'] === '' || $data['expense_date'] === '') {
            $this->json(['success' => false, 'message' => 'Title, amount and expense date are required.'], 422);
        }
        if ($data['amount'] <= 0) {
            $this->json(['success' => false, 'message' => 'Amount must be greater than zero.'], 422);
        }

        $current = Database::fetchOne('SELECT receipt_file FROM expenses WHERE id = :id', ['id' => $id]);
        if (isset($_FILES['receipt_file']) && $_FILES['receipt_file']['error'] === UPLOAD_ERR_OK) {
            try {
                if ($current && $current['receipt_file']) {
                    Uploader::delete($current['receipt_file']);
                }
                $data['receipt_file'] = Uploader::store($_FILES['receipt_file'], 'expenses');
            } catch (\Throwable $e) {
                $this->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
        }

        Database::update('expenses', $data, 'id = :id', ['id' => $id]);
        log_activity('update', 'expenses', "Updated expense #{$id}");
        $this->json(['success' => true, 'message' => 'Expense updated.']);
    }

    public function status(int $id): void
    {
        $this->requirePermission('expenses.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $status = Request::post('status', '') === 'approved' ? 'approved' : 'rejected';
        Database::update('expenses', ['status' => $status], 'id = :id', ['id' => $id]);
        log_activity('update', 'expenses', ucfirst($status) . " expense #{$id}");
        $this->json(['success' => true, 'message' => 'Expense ' . $status . '.']);
    }

    public function delete(int $id): void
    {
        $this->requirePermission('expenses.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $current = Database::fetchOne('SELECT receipt_file FROM expenses WHERE id = :id', ['id' => $id]);
        if ($current && $current['receipt_file']) {
            Uploader::delete($current['receipt_file']);
        }

        Database::delete('expenses', 'id = :id', ['id' => $id]);
        log_activity('delete', 'expenses', "Deleted expense #{$id}");
        $this->json(['success' => true, 'message' => 'Expense deleted.']);
    }

    protected function expensePayload(): array
    {
        $purchasedBy = (int) Request::post('purchased_by', 0);
        return [
            'title'        => trim((string) Request::post('title', '')),
            'category'     => trim((string) Request::post('category', '')),
            'amount'       => (float) Request::post('amount', 0),
            'expense_date' => trim((string) Request::post('expense_date', '')),
            'purchased_by' => $purchasedBy > 0 ? $purchasedBy : null,
            'status'       => in_array(Request::post('status', 'pending'), ['pending', 'approved', 'rejected'], true)
                ? Request::post('status', 'pending') : 'pending',
        ];
    }
}
