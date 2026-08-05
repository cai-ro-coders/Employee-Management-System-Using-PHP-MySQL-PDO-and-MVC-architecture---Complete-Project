<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class Holiday extends Model
{
    protected string $table = 'holidays';

    public function allSorted(): array
    {
        return Database::fetchAll('SELECT * FROM holidays ORDER BY start_date DESC');
    }

    public function upcoming(?int $limit = null): array
    {
        $sql = 'SELECT * FROM holidays WHERE end_date >= CURDATE() ORDER BY start_date ASC';
        if ($limit) {
            $sql .= ' LIMIT ' . (int) $limit;
        }
        return Database::fetchAll($sql);
    }
}
