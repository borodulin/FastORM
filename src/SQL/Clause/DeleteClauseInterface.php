<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use Countable;
use FastOrm\SQL\Clause\Delete\WhereClauseInterface;
use FastOrm\SQL\ExpressionInterface;

interface DeleteClauseInterface extends
    ExpressionInterface,
    Countable,
    HasStatementInterface
{
    public function from($table): WhereClauseInterface;
}
