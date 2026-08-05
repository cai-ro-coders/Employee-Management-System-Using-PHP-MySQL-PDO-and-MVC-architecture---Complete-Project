<?php
declare(strict_types=1);

/**
 * Bootstrap file - loads all core classes, helpers and configuration.
 */

define('BASE_PATH', dirname(__DIR__, 2));
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');
define('VIEW_PATH', APP_PATH . '/views');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('ASSET_PATH', BASE_PATH . '/assets');
define('UPLOAD_PATH', ASSET_PATH . '/uploads');
define('URL_ROOT', (function () {
    $config = require CONFIG_PATH . '/config.php';
    $configured = rtrim($config['app']['url'] ?? '', '/');

    // Derive the base URL from the actual request so any host/port the site is
    // reached by generates consistent links & redirects (prevents redirect loops).
    if (PHP_SAPI !== 'cli' && isset($_SERVER['HTTP_HOST'])) {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $script = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
        $basePath = rtrim(str_replace('/index.php', '', $script), '/');
        return rtrim($scheme . '://' . $_SERVER['HTTP_HOST'] . $basePath, '/');
    }
    return $configured;
})());

/* Autoloader: PSR-4 style for app\* namespaces */
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) === 0) {
        $relative = substr($class, strlen($prefix));
        $file = APP_PATH . '/' . str_replace('\\', '/', $relative) . '.php';
        if (is_file($file)) {
            require $file;
        }
    }
});

/* Application config */
$GLOBALS['config'] = require CONFIG_PATH . '/config.php';
App\Core\Config::load($GLOBALS['config']);

/* Start session */
App\Core\Session::start();

/* Load helpers */
require_once APP_PATH . '/helpers/functions.php';
require_once APP_PATH . '/helpers/Auth.php';
require_once APP_PATH . '/helpers/Validation.php';
require_once APP_PATH . '/helpers/Upload.php';

/* Set timezone */
date_default_timezone_set(App\Core\Config::get('app.timezone', 'Asia/Manila'));

/* Error reporting */
if (App\Core\Config::get('app.debug', false)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}
