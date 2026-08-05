<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Core\Session;
use App\Models\User;

class AuthController extends Controller
{
    protected string $layout = 'auth';

    public function login(): void
    {
        if (\Auth::check()) {
            $this->redirect('dashboard');
        }

        if (Request::isPost()) {
            if (!Request::validateCsrf()) {
                Session::flash('error', 'Invalid security token. Please try again.');
                $this->redirectBack();
            }

            $identifier = trim((string) Request::post('identifier', ''));
            $password   = (string) Request::post('password', '');
            $remember   = Request::post('remember', '') === 'on';

            if ($identifier === '' || $password === '') {
                Session::flash('error', 'Please enter your email/username and password.');
                $this->redirectBack();
            }

            if (\Auth::attempt($identifier, $password, $remember)) {
                $this->redirect('dashboard');
            }

            Session::flash('error', 'Invalid credentials or your account is inactive.');
            Session::set('_old_input', ['identifier' => $identifier]);
            $this->redirectBack();
        }

        $this->view('auth/login', ['title' => 'Sign In']);
    }

    public function logout(): void
    {
        \Auth::logout();
        Session::flash('success', 'You have been logged out.');
        $this->redirect('login');
    }

    public function forgotPassword(): void
    {
        if (Request::isPost()) {
            if (!Request::validateCsrf()) {
                Session::flash('error', 'Invalid security token.');
                $this->redirectBack();
            }
            $email = trim((string) Request::post('email', ''));
            $user = (new User())->findByEmailOrUsername($email);

            if ($user) {
                $token = bin2hex(random_bytes(32));
                Database::update('users', [
                    'password_reset_token'   => $token,
                    'password_reset_expires' => date('Y-m-d H:i:s', time() + 3600),
                    'updated_at'             => date('Y-m-d H:i:s'),
                ], 'id = :id', ['id' => $user['id']]);

                log_activity('request_reset', 'auth', 'Password reset requested for ' . $user['email']);

                // In production an email is sent. For local demo we expose the link.
                $resetUrl = url('reset-password?token=' . $token);
                Session::flash('success', 'Reset link generated (demo): ' . $resetUrl);
            } else {
                Session::flash('info', 'If that email exists, a reset link has been sent.');
            }
            $this->redirectBack();
        }

        $this->view('auth/forgot-password', ['title' => 'Forgot Password']);
    }

    public function resetPassword(): void
    {
        if (Request::isPost()) {
            if (!Request::validateCsrf()) {
                Session::flash('error', 'Invalid security token.');
                $this->redirectBack();
            }

            $token    = (string) Request::post('token', '');
            $password = (string) Request::post('password', '');
            $confirm  = (string) Request::post('password_confirmation', '');

            if ($password !== $confirm) {
                Session::flash('error', 'Passwords do not match.');
                Session::set('_old_input', ['token' => $token]);
                $this->redirectBack();
            }
            if (strlen($password) < 8) {
                Session::flash('error', 'Password must be at least 8 characters.');
                Session::set('_old_input', ['token' => $token]);
                $this->redirectBack();
            }

            $user = Database::fetchOne(
                'SELECT * FROM users WHERE password_reset_token = :token AND password_reset_expires > NOW()',
                ['token' => $token]
            );

            if (!$user) {
                Session::flash('error', 'Invalid or expired reset token.');
                $this->redirect('forgot-password');
            }

            Database::update('users', [
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'password_reset_token' => null,
                'password_reset_expires' => null,
                'updated_at' => date('Y-m-d H:i:s'),
            ], 'id = :id', ['id' => $user['id']]);

            log_activity('reset_password', 'auth', 'Password reset for ' . $user['email']);
            Session::flash('success', 'Password updated. You can now sign in.');
            $this->redirect('login');
        }

        $token = (string) Request::query('token', '');
        if ($token === '') {
            Session::flash('error', 'Missing reset token.');
            $this->redirect('forgot-password');
        }
        $this->view('auth/reset-password', ['title' => 'Reset Password', 'token' => $token]);
    }
}
