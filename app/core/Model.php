<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Base Model - thin data layer built on the Database singleton.
 * Uses the Repository pattern: models expose focused query methods.
 */
abstract class Model
{
    protected string $table = '';

    public function table(): string
    {
        return $this->table;
    }

    public function find(int $id): ?array
    {
        return Database::fetchOne("SELECT * FROM `{$this->table}` WHERE id = :id LIMIT 1", ['id' => $id]);
    }

    public function all(?string $orderBy = null): array
    {
        $sql = "SELECT * FROM `{$this->table}`";
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        return Database::fetchAll($sql);
    }

    public function allWhere(string $where, array $params = [], ?string $orderBy = null): array
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE {$where}";
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        return Database::fetchAll($sql, $params);
    }

    public function create(array $data): int
    {
        if (!empty($this->timestamps)) {
            $now = date('Y-m-d H:i:s');
            $data['created_at'] = $now;
            $data['updated_at'] = $now;
        }
        return Database::insert($this->table, $data);
    }

    public function update(int $id, array $data): int
    {
        if (!empty($this->timestamps)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        return Database::update($this->table, $data, 'id = :id', ['id' => $id]);
    }

    public function delete(int $id): int
    {
        return Database::delete($this->table, 'id = :id', ['id' => $id]);
    }

    public function count(?string $where = null, array $params = []): int
    {
        $sql = "SELECT COUNT(*) FROM `{$this->table}`";
        if ($where) {
            $sql .= " WHERE {$where}";
        }
        return (int) Database::fetchColumn($sql, $params, 0);
    }

    public function paginate(int $page, int $perPage, ?string $where = null, array $params = [], ?string $orderBy = null): array
    {
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT * FROM `{$this->table}`";
        $countSql = "SELECT COUNT(*) FROM `{$this->table}`";
        if ($where) {
            $sql .= " WHERE {$where}";
            $countSql .= " WHERE {$where}";
        }
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        $sql .= " LIMIT {$perPage} OFFSET {$offset}";

        $total = (int) Database::fetchColumn($countSql, $params, 0);
        return [
            'items'  => Database::fetchAll($sql, $params),
            'total'  => $total,
            'page'   => $page,
            'perPage'=> $perPage,
            'pages'  => (int) ceil($total / $perPage),
        ];
    }
}