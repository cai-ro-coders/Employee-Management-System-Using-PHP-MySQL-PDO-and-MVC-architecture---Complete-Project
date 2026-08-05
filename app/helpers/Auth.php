<?php
declare(strict_types=1);

use App\Core\Database;
use App\Core\Session;
use App\Core\Security;

/**
 * Auth helper: current user, RBAC checks, remember-me handling.
 */
class Auth
{
    public static function check(): bool
    {
        return Session::has('user_id');
    }

    public static function id(): ?int
    {
        return Session::has('user_id') ? (int) Session::get('user_id') : null;
    }

    public static function user(): ?array
    {
        static $user = null;
        if ($user === null && self::check()) {
            $user = Database::fetchOne(
                'SELECT u.*, r.name AS role_name FROM users u
                 JOIN roles r ON r.id = u.role_id
                 WHERE u.id = :id AND u.status = "active" LIMIT 1',
                ['id' => self::id()]
            );
            if (!$user) {
                self::logout();
            }
        }
        return $user;
    }

    public static function role(): string
    {
        $user = self::user();
        return $user['role_name'] ?? '';
    }

    public static function roleId(): ?int
    {
        $user = self::user();
        return $user ? (int) $user['role_id'] : null;
    }

    /**
     * RBAC: check permission_key for the current user's role.
     * Super Admin bypasses all checks.
     */
    public static function can(string $permission): bool
    {
        $user = self::user();
        if (!$user) {
            return false;
        }
        if (strtolower($user['role_name']) === 'super admin') {
            return true;
        }

        static $perms = null;
        if ($perms === null) {
            $perms = [];
            foreach (Database::fetchAll(
                'SELECT p.permission_key FROM role_permissions rp
                 JOIN permissions p ON p.id = rp.permission_id
                 WHERE rp.role_id = :role_id',
                ['role_id' => $user['role_id']]
            ) as $row) {
                $perms[$row['permission_key']] = true;
            }
        }
        return isset($perms[$permission]);
    }

    public static function hasAny(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (self::can($permission)) {
                return true;
            }
        }
        return false;
    }

    public static function logout(): void
    {
        log_activity('logout', 'auth', 'User logged out');
        $userId = self::id();
        $rememberToken = self::user()['remember_token'] ?? null;
        if ($rememberToken) {
            Database::update('users', ['remember_token' => null, 'updated_at' => date('Y-m-d H:i:s')], 'id = :id', ['id' => $userId]);
        }
        if ($rememberToken) {
            setcookie('remember_me', '', time() - 3600, '/', '', false, true);
        }
        Session::destroy();
    }

    /**
     * Attempt login with remember-me support.
     */
    public static function attempt(string $identifier, string $password, bool $remember = false): bool
    {
        $user = Database::fetchOne(
            'SELECT u.*, r.name AS role_name FROM users u
             JOIN roles r ON r.id = u.role_id
             WHERE (u.email = :id1 OR u.username = :id2) AND u.status = "active" LIMIT 1',
            ['id1' => $identifier, 'id2' => $identifier]
        );

        if (!$user || !Security::verifyPassword($password, $user['password'])) {
            self::recordLogin($user['id'] ?? null, false, 'Invalid credentials');
            return false;
        }

        $now = date('Y-m-d H:i:s');
        Database::update('users', ['last_login' => $now, 'updated_at' => $now], 'id = :id', ['id' => $user['id']]);

        Session::set('user_id', (int) $user['id']);
        Session::set('user_name', $user['first_name'] . ' ' . $user['last_name']);
        Session::set('user_role', $user['role_name']);

        if ($remember) {
            $token = bin2hex(random_bytes(32));
            Database::update('users', ['remember_token' => Security::hashPassword($token), 'updated_at' => $now], 'id = :id', ['id' => $user['id']]);
            setcookie('remember_me', $user['id'] . ':' . $token, time() + 30 * 24 * 3600, '/', '', false, true);
        }

        self::recordLogin($user['id'], true, 'Login successful');
        log_activity('login', 'auth', 'User logged in');
        return true;
    }

    /**
     * Restore session from remember-me cookie.
     */
    public static function rememberAttempt(): bool
    {
        if (!isset($_COOKIE['remember_me'])) {
            return false;
        }
        [$id, $token] = explode(':', $_COOKIE['remember_me'], 2);
        $user = Database::fetchOne('SELECT * FROM users WHERE id = :id AND status = "active" LIMIT 1', ['id' => (int) $id]);
        if ($user && $user['remember_token'] && Security::verifyPassword($token, $user['remember_token'])) {
            Session::set('user_id', (int) $user['id']);
            Session::set('user_name', $user['first_name'] . ' ' . $user['last_name']);
            Session::set('user_role', self::roleFromId($user['role_id']));
            Database::update('users', ['last_login' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')], 'id = :id', ['id' => $user['id']]);
            return true;
        }
        setcookie('remember_me', '', time() - 3600, '/', '', false, true);
        return false;
    }

    protected static function roleFromId(int $roleId): string
    {
        return (string) Database::fetchColumn('SELECT name FROM roles WHERE id = :id', ['id' => $roleId], '');
    }

    protected static function recordLogin(?int $userId, bool $success, string $message): void
    {
        Database::insert('login_history', [
            'user_id'     => $userId,
            'ip_address'  => \App\Core\Request::ip(),
            'user_agent'  => \App\Core\Request::userAgent(),
            'status'      => $success ? 'success' : 'failed',
            'message'     => $message,
            'login_at'    => date('Y-m-d H:i:s'),
        ]);
    }
}
