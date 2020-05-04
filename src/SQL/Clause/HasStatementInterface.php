<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\PdoCommand\StatementInterface;

interface HasStatementInterface
{
    public function statement(array $options = []): StatementInterface;
}
