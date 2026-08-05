<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

/**
 * PDO Database singleton with prepared-statement helpers.
 * Guards against SQL injection everywhere via prepared statements.
 */
class Database
{
    protected static ?Database $instance = null;
    protected PDO $pdo;

    private function __construct()
    {
        $db = Config::get('database', []);

        $socket = $db['socket'] ?? null;
        $useSocket = $socket && file_exists($socket);

        if ($useSocket) {
            $dsn = sprintf(
                'mysql:dbname=%s;unix_socket=%s;charset=%s',
                $db['database'] ?? '',
                $socket,
                $db['charset'] ?? 'utf8mb4'
            );
        } else {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $db['host'] ?? '127.0.0.1',
                $db['port'] ?? '3306',
                $db['database'] ?? '',
                $db['charset'] ?? 'utf8mb4'
            );
        }

        try {
            $this->pdo = new PDO($dsn, $db['username'] ?? 'root', $db['password'] ?? '', [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_PERSISTENT         => true,
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function connect(): PDO
    {
        return self::instance()->pdo;
    }

    public static function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = self::connect()->prepare($sql);
        try {
            $stmt->execute($params);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage() . "\nSQL: " . $sql . "\nParams: " . json_encode($params), (int) $e->getCode(), $e);
        }
        return $stmt;
    }

    public static function fetchAll(string $sql, array $params = []): array
    {
        return self::query($sql, $params)->fetchAll();
    }

    public static function fetchOne(string $sql, array $params = []): ?array
    {
        $row = self::query($sql, $params)->fetch();
        return $row === false ? null : $row;
    }

    public static function fetchColumn(string $sql, array $params = [], $default = null)
    {
        $value = self::query($sql, $params)->fetchColumn();
        return $value === false ? $default : $value;
    }

    public static function insert(string $table, array $data): int
    {
        $columns = array_keys($data);
        $placeholders = array_map(fn($c) => ':' . $c, $columns);
        $sql = sprintf(
            'INSERT INTO `%s` (%s) VALUES (%s)',
            $table,
            implode(', ', array_map(fn($c) => '`' . $c . '`', $columns)),
            implode(', ', $placeholders)
        );
        self::query($sql, $data);
        return (int) self::connect()->lastInsertId();
    }

    public static function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        $sets = [];
        $params = [];
        foreach ($data as $col => $value) {
            $key = ':' . $col;
            $sets[] = "`$col` = $key";
            $params[$key] = $value;
        }
        $params = array_merge($params, $whereParams);
        $sql = sprintf('UPDATE `%s` SET %s WHERE %s', $table, implode(', ', $sets), $where);
        return self::query($sql, $params)->rowCount();
    }

    public static function delete(string $table, string $where, array $whereParams = []): int
    {
        $sql = sprintf('DELETE FROM `%s` WHERE %s', $table, $where);
        return self::query($sql, $whereParams)->rowCount();
    }

    public static function transaction(callable $callback)
    {
        $pdo = self::connect();
        $pdo->beginTransaction();
        try {
            $result = $callback($pdo);
            $pdo->commit();
            return $result;
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function lastInsertId(): int
    {
        return (int) self::connect()->lastInsertId();
    }

    public function pdo(): PDO
    {
        return $this->pdo;
    }
}
