<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\PdoCommand\StatementInterface;

interface HasStatementInterface
{
    /**
     * @param array $options
     * @return StatementInterface
     */
    public function statement(array $options = []): StatementInterface;
}
