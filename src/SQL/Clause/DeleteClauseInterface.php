<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\Clause\Delete\WhereClauseInterface;
use FastOrm\SQL\ExpressionInterface;

interface DeleteClauseInterface extends ExpressionInterface
{
    public function from($table): WhereClauseInterface;
}
