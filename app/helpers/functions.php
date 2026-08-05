<?php
declare(strict_types=1);

use App\Core\Session;
use App\Core\Security;
use App\Core\Config;

/* ---------- Output escaping ---------- */
if (!function_exists('e')) {
    function e($value): string
    {
        return Security::e($value);
    }
}

/* ---------- Asset URL ---------- */
if (!function_exists('asset')) {
    function asset(string $path): string
    {
        return URL_ROOT . '/assets/' . ltrim($path, '/');
    }
}

/* ---------- Public URL ---------- */
if (!function_exists('url')) {
    function url(string $path = ''): string
    {
        return URL_ROOT . '/' . ltrim($path, '/');
    }
}

/* ---------- Old input ---------- */
if (!function_exists('old')) {
    function old(string $key, $default = ''): string
    {
        $old = Session::get('_old_input', []);
        return isset($old[$key]) ? e($old[$key]) : e($default);
    }
}

/* ---------- Flash helpers ---------- */
if (!function_exists('flash')) {
    function flash(): void
    {
        $types = ['success', 'error', 'warning', 'info'];
        foreach ($types as $type) {
            if (Session::hasFlash($type)) {
                $message = Session::flash($type);
                if ($message) {
                    echo '<div class="alert alert-' . ($type === 'error' ? 'danger' : $type) . ' alert-dismissible fade show" role="alert">'
                        . e($message)
                        . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
            }
        }
    }
}

/* ---------- CSRF hidden input ---------- */
if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        return '<input type="hidden" name="_token" value="' . Session::csrfToken() . '">';
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        return Session::csrfToken();
    }
}

/* ---------- Money formatting ---------- */
if (!function_exists('money')) {
    function money($amount, string $currency = 'PHP'): string
    {
        return number_format((float) $amount, 2);
    }
}

/* ---------- Date formatting ---------- */
if (!function_exists('format_date')) {
    function format_date($date, string $format = 'M d, Y'): string
    {
        if (empty($date)) {
            return '-';
        }
        return date($format, strtotime((string) $date));
    }
}

if (!function_exists('time_ago')) {
    function time_ago($datetime): string
    {
        if (empty($datetime)) {
            return '-';
        }
        $time = strtotime((string) $datetime);
        $diff = time() - $time;
        if ($diff < 60) return 'just now';
        if ($diff < 3600) return floor($diff / 60) . 'm ago';
        if ($diff < 86400) return floor($diff / 3600) . 'h ago';
        if ($diff < 604800) return floor($diff / 86400) . 'd ago';
        return date('M d, Y', $time);
    }
}

/* ---------- Status badge ---------- */
if (!function_exists('status_badge')) {
    function status_badge(string $status): string
    {
        $map = [
            'active'    => ['success', 'Active'],
            'inactive'  => ['secondary', 'Inactive'],
            'pending'   => ['warning', 'Pending'],
            'approved'  => ['success', 'Approved'],
            'rejected'  => ['danger', 'Rejected'],
            'paid'      => ['success', 'Paid'],
            'unpaid'    => ['danger', 'Unpaid'],
            'completed' => ['success', 'Completed'],
            'in_progress' => ['info', 'In Progress'],
            'present'   => ['success', 'Present'],
            'absent'    => ['danger', 'Absent'],
            'on_leave'  => ['warning', 'On Leave'],
            'half_day'  => ['info', 'Half Day'],
        ];
        $key = strtolower(str_replace(' ', '_', $status));
        [$class, $label] = $map[$key] ?? ['secondary', ucwords(str_replace('_', ' ', $status))];
        return '<span class="badge bg-' . $class . '">' . e($label) . '</span>';
    }
}

/* ---------- Avatar ---------- */
if (!function_exists('avatar')) {
    function avatar(?string $avatar, ?string $name = 'U'): string
    {
        if ($avatar && file_exists(UPLOAD_PATH . '/' . $avatar)) {
            return asset('uploads/' . $avatar);
        }
        $initials = '';
        foreach (preg_split('/[\s]+/', trim((string) $name)) as $part) {
            if ($part !== '') $initials .= strtoupper(mb_substr($part, 0, 1));
        }
        $initials = $initials !== '' ? mb_substr($initials, 0, 2) : 'U';
        $colors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
        $color = $colors[abs(crc32((string) $name)) % count($colors)];
        return 'data:image/svg+xml;base64,' . base64_encode(
            '<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80"><rect width="80" height="80" fill="#6f42c1" rx="40"/><text x="50%" y="54%" font-family="Arial" font-size="28" fill="#fff" text-anchor="middle" dominant-baseline="middle">' . $initials . '</text></svg>'
        );
    }
}

/* ---------- Settings ---------- */
if (!function_exists('setting')) {
    function setting(string $key, $default = ''): string
    {
        static $cache = null;
        if ($cache === null) {
            $cache = [];
            foreach (\App\Core\Database::fetchAll('SELECT * FROM settings') as $row) {
                $cache[$row['setting_key']] = $row['setting_value'];
            }
        }
        return (string) ($cache[$key] ?? $default);
    }
}

/* ---------- Activity logger (Audit Logs) ---------- */
if (!function_exists('log_activity')) {
    function log_activity(string $action, string $module, string $description = ''): void
    {
        $userId = \App\Core\Session::get('user_id');
        \App\Core\Database::insert('activity_logs', [
            'user_id'    => $userId,
            'action'     => $action,
            'module'     => $module,
            'description'=> substr($description, 0, 500),
            'ip_address' => \App\Core\Request::ip(),
            'user_agent' => \App\Core\Request::userAgent(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
