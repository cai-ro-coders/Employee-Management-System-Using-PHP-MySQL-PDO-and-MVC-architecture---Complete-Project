<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Core\Session;
use App\Models\Customer;
use \Upload as Uploader;

class CustomerController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('customers.view');
        $this->view('customers/index', [
            'title'     => 'Customers',
            'customers' => (new Customer())->searchableList(),
            'tags'      => (new Customer())->allTags(),
        ]);
    }

    public function dataTable(): void
    {
        $this->requirePermission('customers.view');
        $search = trim((string) Request::query('search', ''));
        $status = trim((string) Request::query('status', ''));
        $type   = trim((string) Request::query('type', ''));
        $this->json(['data' => (new Customer())->searchableList($search ?: null, $status ?: null, $type ?: null)]);
    }

    public function store(): void
    {
        $this->requirePermission('customers.create');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $first = trim((string) Request::post('first_name', ''));
        $last  = trim((string) Request::post('last_name', ''));
        if ($first === '' || $last === '') {
            $this->json(['success' => false, 'message' => 'First and last name are required.'], 422);
        }

        $data = [
            'first_name'   => $first,
            'last_name'    => $last,
            'company'      => trim((string) Request::post('company', '')),
            'email'        => trim((string) Request::post('email', '')),
            'phone'        => trim((string) Request::post('phone', '')),
            'mobile'       => trim((string) Request::post('mobile', '')),
            'website'      => trim((string) Request::post('website', '')),
            'industry'     => trim((string) Request::post('industry', '')),
            'customer_type'=> Request::post('customer_type', 'individual') === 'business' ? 'business' : 'individual',
            'status'       => Request::post('status', 'active') === 'active' ? 'active' : 'inactive',
            'address'      => trim((string) Request::post('address', '')),
            'city'         => trim((string) Request::post('city', '')),
            'state'        => trim((string) Request::post('state', '')),
            'country'      => trim((string) Request::post('country', '')),
            'postal_code'  => trim((string) Request::post('postal_code', '')),
            'notes'        => trim((string) Request::post('notes', '')),
        ];

        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            try {
                $data['profile_image'] = Uploader::store($_FILES['profile_image'], 'customers', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            } catch (\Throwable $e) {
                $this->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
        }

        $id = Database::insert('customers', $data);

        if (Request::post('tags', '') !== '') {
            foreach (explode(',', (string) Request::post('tags', '')) as $tagName) {
                $tagName = trim($tagName);
                if ($tagName === '') continue;
                $tagId = (int) Database::fetchColumn('SELECT id FROM customer_tags WHERE name = :n', ['n' => $tagName], 0);
                if (!$tagId) {
                    $tagId = Database::insert('customer_tags', ['name' => $tagName]);
                }
                Database::insert('customer_tag', ['customer_id' => $id, 'tag_id' => $tagId]);
            }
        }

        log_activity('create', 'customers', "Created customer {$first} {$last}");
        $this->json(['success' => true, 'message' => 'Customer created.']);
    }

    public function update(int $id): void
    {
        $this->requirePermission('customers.edit');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }

        $data = [
            'first_name'   => trim((string) Request::post('first_name', '')),
            'last_name'    => trim((string) Request::post('last_name', '')),
            'company'      => trim((string) Request::post('company', '')),
            'email'        => trim((string) Request::post('email', '')),
            'phone'        => trim((string) Request::post('phone', '')),
            'mobile'       => trim((string) Request::post('mobile', '')),
            'website'      => trim((string) Request::post('website', '')),
            'industry'     => trim((string) Request::post('industry', '')),
            'customer_type'=> Request::post('customer_type', 'individual') === 'business' ? 'business' : 'individual',
            'status'       => Request::post('status', 'active') === 'active' ? 'active' : 'inactive',
            'address'      => trim((string) Request::post('address', '')),
            'city'         => trim((string) Request::post('city', '')),
            'state'        => trim((string) Request::post('state', '')),
            'country'      => trim((string) Request::post('country', '')),
            'postal_code'  => trim((string) Request::post('postal_code', '')),
            'notes'        => trim((string) Request::post('notes', '')),
        ];

        if ($data['first_name'] === '' || $data['last_name'] === '') {
            $this->json(['success' => false, 'message' => 'First and last name are required.'], 422);
        }

        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            try {
                $data['profile_image'] = Uploader::store($_FILES['profile_image'], 'customers', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            } catch (\Throwable $e) {
                $this->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
        }

        Database::update('customers', $data, 'id = :id', ['id' => $id]);
        log_activity('update', 'customers', "Updated customer #{$id}");
        $this->json(['success' => true, 'message' => 'Customer updated.']);
    }

    public function delete(int $id): void
    {
        $this->requirePermission('customers.delete');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }
        (new Customer())->softDelete($id);
        log_activity('delete', 'customers', "Soft-deleted customer #{$id}");
        $this->json(['success' => true, 'message' => 'Customer deleted (soft).']);
    }

    public function notes(int $id): void
    {
        $this->requirePermission('customers.view');
        $this->json(['data' => (new Customer())->notes($id)]);
    }
}
