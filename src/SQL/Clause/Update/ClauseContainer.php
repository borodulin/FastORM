<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Update;

use FastOrm\SQL\Clause\Compound\ClauseContainer as BaseClauseContainer;
use FastOrm\SQL\Clause\Compound\ConditionInterface;
use FastOrm\SQL\Clause\UpdateClauseInterface;

class ClauseContainer extends BaseClauseContainer implements
    UpdateClauseInterface,
    SetClauseInterface,
    WhereClauseInterface
{
    public function update(string $table): SetClauseInterface
    {
        return $this;
    }

    public function set(array $set): WhereClauseInterface
    {
        return $this;
    }

    public function where(): ConditionInterface
    {
        // TODO: Implement where() method.
        return $this;
    }

    public function __clone()
    {
        $this->compound = clone $this->compound;
    }
}
