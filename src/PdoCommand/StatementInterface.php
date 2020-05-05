<?php

declare(strict_types=1);

namespace Borodulin\ORM\PdoCommand;

use PDOStatement;

interface StatementInterface
{
    public function prepare(iterable $params = []): PDOStatement;

    public function execute(iterable $params = []): PDOStatement;
}
