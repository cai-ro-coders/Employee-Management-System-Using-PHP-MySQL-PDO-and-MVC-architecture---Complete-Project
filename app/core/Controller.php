<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Base Controller - handles rendering, redirects, JSON responses and RBAC guards.
 */
abstract class Controller
{
    protected string $layout = 'default';
    protected array $viewData = [];

    protected function view(string $view, array $data = []): void
    {
        $data = array_merge($this->viewData, $data);
        $viewFile = VIEW_PATH . '/' . $view . '.php';

        extract($data, EXTR_SKIP);

        $layoutFile = VIEW_PATH . '/layouts/' . $this->layout . '.php';
        $content = '';

        ob_start();
        if (is_file($viewFile)) {
            require $viewFile;
        } else {
            echo '<div class="alert alert-danger">View not found: ' . e($view) . '</div>';
        }
        $content = ob_get_clean();

        require $layoutFile;
    }

    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . URL_ROOT . '/' . ltrim($path, '/'));
        exit;
    }

    protected function redirectBack(): void
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? URL_ROOT . '/dashboard';
        header('Location: ' . $referer);
        exit;
    }

    protected function requireAuth(): void
    {
        if (!\Auth::check()) {
            Session::flash('error', 'Please login to continue.');
            $this->redirect('login');
        }
    }

    protected function requirePermission(string $permission): void
    {
        $this->requireAuth();
        if (!\Auth::can($permission)) {
            http_response_code(403);
            if (Request::wantsJson()) {
                $this->json(['success' => false, 'message' => 'You do not have permission to perform this action.'], 403);
            }
            $this->view('errors/403', ['title' => '403 Forbidden']);
            exit;
        }
    }

    protected function requireRole(...$roles): void
    {
        $this->requireAuth();
        if (!in_array(strtolower(\Auth::role()), array_map('strtolower', $roles), true)) {
            http_response_code(403);
            if (Request::wantsJson()) {
                $this->json(['success' => false, 'message' => 'Access denied.'], 403);
            }
            $this->view('errors/403', ['title' => '403 Forbidden']);
            exit;
        }
    }
}
