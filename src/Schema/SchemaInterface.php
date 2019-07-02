<?php

declare(strict_types=true);

namespace FastOrm\Schema;

use PDO;

interface SchemaInterface
{
    public function setTransactionIsolationLevel(string $isolationLevel): void;

    public function getPDO(): PDO;

    public function quoteColumnName(string $name): string;

    public function getPdoType($value);
}
