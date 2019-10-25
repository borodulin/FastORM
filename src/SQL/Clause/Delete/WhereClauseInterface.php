<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Delete;

use FastOrm\SQL\Clause\Compound\ConditionInterface;

interface WhereClauseInterface
{
    public function where(): ConditionInterface;
}
