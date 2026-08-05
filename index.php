<?php
declare(strict_types=1);

/**
 * Front Controller
 */

require __DIR__ . '/app/core/Bootstrap.php';

// Prevent the browser from caching pages/redirects (avoids phantom redirect loops)
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

try {
    $app = new \App\Core\App();
} catch (Throwable $e) {
    if (\App\Core\Config::get('app.debug', false)) {
        echo '<pre style="background:#f8d7da;padding:20px;border-radius:6px;color:#842029;">'
            . e($e->getMessage()) . "\n\n" . e($e->getFile() . ':' . $e->getLine()) . '</pre>';
    } else {
        http_response_code(500);
        echo '500 Internal Server Error';
    }
}
