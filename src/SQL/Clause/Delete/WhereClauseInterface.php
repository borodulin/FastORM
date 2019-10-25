<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Delete;

use FastOrm\SQL\Clause\ExecuteInterface;

interface WhereClauseInterface extends ExecuteInterface
{
    public function where(): ConditionInterface;
}
