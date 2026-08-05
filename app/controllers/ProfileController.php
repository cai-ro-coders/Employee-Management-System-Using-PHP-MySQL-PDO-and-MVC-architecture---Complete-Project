<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Core\Session;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        $user = (new User())->withRole(\Auth::id());

        $this->view('profile/index', [
            'title' => 'My Profile',
            'user'  => $user,
        ]);
    }

    public function update(): void
    {
        $this->requireAuth();
        if (!Request::validateCsrf()) {
            Session::flash('error', 'Invalid security token.');
            $this->redirectBack();
        }

        $data = [
            'first_name' => trim((string) Request::post('first_name', '')),
            'last_name'  => trim((string) Request::post('last_name', '')),
            'phone'      => trim((string) Request::post('phone', '')),
            'address'    => trim((string) Request::post('address', '')),
        ];

        if ($data['first_name'] === '' || $data['last_name'] === '') {
            Session::flash('error', 'First and last name are required.');
            $this->redirectBack();
        }

        Database::update('users', $data, 'id = :id', ['id' => \Auth::id()]);
        Session::set('user_name', $data['first_name'] . ' ' . $data['last_name']);
        log_activity('update', 'profile', 'Updated profile');
        Session::flash('success', 'Profile updated successfully.');
        $this->redirectBack();
    }

    public function updateAvatar(): void
    {
        $this->requireAuth();
        if (!Request::validateCsrf()) {
            Session::flash('error', 'Invalid security token.');
            $this->redirectBack();
        }

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            try {
                $path = \Upload::store($_FILES['avatar'], 'avatars', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                if ($path) {
                    $old = Database::fetchColumn('SELECT avatar FROM users WHERE id = :id', ['id' => \Auth::id()], null);
                    Database::update('users', ['avatar' => $path], 'id = :id', ['id' => \Auth::id()]);
                    \Upload::delete($old);
                    log_activity('update', 'profile', 'Updated profile avatar');
                    Session::flash('success', 'Avatar updated.');
                }
            } catch (\Throwable $e) {
                Session::flash('error', $e->getMessage());
            }
        }
        $this->redirectBack();
    }

    public function changePassword(): void
    {
        $this->requireAuth();

        if (Request::isPost()) {
            if (!Request::validateCsrf()) {
                Session::flash('error', 'Invalid security token.');
                $this->redirectBack();
            }

            $current  = (string) Request::post('current_password', '');
            $new      = (string) Request::post('new_password', '');
            $confirm  = (string) Request::post('new_password_confirmation', '');

            $user = (new User())->find(\Auth::id());
            if (!$user || !password_verify($current, $user['password'])) {
                Session::flash('error', 'Current password is incorrect.');
                $this->redirectBack();
            }
            if (strlen($new) < 8) {
                Session::flash('error', 'New password must be at least 8 characters.');
                $this->redirectBack();
            }
            if ($new !== $confirm) {
                Session::flash('error', 'New password confirmation does not match.');
                $this->redirectBack();
            }

            Database::update('users', ['password' => password_hash($new, PASSWORD_DEFAULT)], 'id = :id', ['id' => \Auth::id()]);
            log_activity('update', 'profile', 'Changed password');
            Session::flash('success', 'Password changed successfully.');
            $this->redirect('profile');
        }

        $this->view('profile/change-password', ['title' => 'Change Password']);
    }
}
