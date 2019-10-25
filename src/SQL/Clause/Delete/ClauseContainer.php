<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Delete;

use FastOrm\SQL\Clause\Compound\ClauseContainer as BaseClauseContainer;
use FastOrm\SQL\Clause\Compound\ConditionInterface;
use FastOrm\SQL\Clause\DeleteClauseInterface;

class ClauseContainer extends BaseClauseContainer implements
    DeleteClauseInterface,
    WhereClauseInterface,
    ConditionInterface
{

    public function from($table): WhereClauseInterface
    {
        return $this;
    }

    public function where(): ConditionInterface
    {
        return $this;
    }

    public function __clone()
    {
        $this->compound = clone $this->compound;
    }
}
