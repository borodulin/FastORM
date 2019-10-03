<?php

declare(strict_types=1);

namespace FastOrm\PdoCommand;

use PDOStatement;

interface StatementInterface
{
    public function prepare(array $params = []): PDOStatement;

    public function execute(array $params = []): PDOStatement;
}
