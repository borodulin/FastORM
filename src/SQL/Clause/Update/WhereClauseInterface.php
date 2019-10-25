<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Update;

use FastOrm\SQL\Clause\Compound\ConditionInterface;

interface WhereClauseInterface
{
    public function where(): ConditionInterface;
}
