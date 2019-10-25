<?php

namespace FastOrm\SQL\Clause;

use Countable;
use FastOrm\SQL\Clause\Update\ConditionInterface;
use FastOrm\SQL\ExpressionInterface;

interface UpdateClauseInterface extends
    ExpressionInterface,
    ExecuteInterface,
    HasStatementInterface,
    Countable
{
    public function update($table): self;

    public function set(array $set): self;

    public function where(): ConditionInterface;
}
