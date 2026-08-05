<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Front controller / router: parses the URL into Controller@method + params.
 */
class App
{
    protected string $controller = 'DashboardController';
    protected string $method = 'index';
    protected array $params = [];

    public function __construct()
    {
        $routes = require BASE_PATH . '/routes/web.php';

        $url = $this->parseUrl();
        $path = !empty($url) ? '/' . implode('/', $url) : '/';

        // 1) Explicit route match
        if (isset($routes[$path])) {
            [$controller, $method] = $routes[$path];
        } else {
            // 2) fallback to /controller/method(/params)
            $segment = ($url[0] ?? '') ? $this->toCamel($url[0]) : 'Dashboard';
            $controller = ucfirst($this->singularize($segment)) . 'Controller';
            $method = $url[1] ?? 'index';
            if (count($url) > 2) {
                $this->params = array_map(
                    fn($p) => ctype_digit($p) ? (int) $p : $p,
                    array_slice($url, 2)
                );
            }
        }

        $controllerClass = 'App\\Controllers\\' . $controller;

        if (!class_exists($controllerClass)) {
            // try the non-singular (original) form before giving up
            $alt = 'App\\Controllers\\' . ucfirst($this->toCamel($url[0] ?? 'Dashboard')) . 'Controller';
            if (class_exists($alt)) {
                $controllerClass = $alt;
            } else {
                $controllerClass = 'App\\Controllers\\DashboardController';
            }
        }

        if (!method_exists($controllerClass, $method)) {
            $method = 'index';
        }

        $instance = new $controllerClass();
        call_user_func_array([$instance, $method], $this->params);
    }

    /**
     * Best-effort singularization for controller name resolution.
     * e.g. employees -> employee, customers -> customer, salaries -> salary
     */
    protected function singularize(string $word): string
    {
        $word = strtolower($word);
        $map = ['statuses' => 'status', 'notices' => 'notice', 'expenses' => 'expense', 'payslips' => 'payslip', 'documents' => 'document', 'holidays' => 'holiday', 'salaries' => 'salary'];
        if (isset($map[$word])) return $map[$word];
        if (substr($word, -3) === 'ies') return substr($word, 0, -3) . 'y';
        if (substr($word, -4) === 'sses') return substr($word, 0, -2);
        if (substr($word, -3) === 'ses') return substr($word, 0, -2);
        if (substr($word, -1) === 's') return substr($word, 0, -1);
        return $word;
    }

    protected function parseUrl(): array
    {
        $url = $_GET['url'] ?? '';
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        return array_values(array_filter($url));
    }

    protected function toCamel(string $str): string
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $str)));
    }
}