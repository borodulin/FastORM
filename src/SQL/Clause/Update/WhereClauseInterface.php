<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Update;

use Countable;
use FastOrm\SQL\Clause\ExecuteInterface;
use FastOrm\SQL\Clause\HasStatementInterface;

interface WhereClauseInterface extends
    ExecuteInterface,
    HasStatementInterface,
    Countable
{
    public function where(): ConditionInterface;
}
