<?php

declare(strict_types=1);

namespace FastOrm\PdoCommand\Fetch;

use PDO;
use PDOStatement;

interface CursorFactoryInterface
{
    public function create(PDOStatement $statement, int $fetchStyle = PDO::FETCH_ASSOC): CursorInterface;
}
