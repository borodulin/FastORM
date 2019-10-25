<?php

namespace FastOrm\SQL\Clause;

use Countable;
use FastOrm\SQL\Clause\Update\SetClauseInterface;
use FastOrm\SQL\ExpressionInterface;

interface UpdateClauseInterface extends
    Countable,
    ExpressionInterface,
    HasStatementInterface
{
    public function update(string $table): SetClauseInterface;
}
