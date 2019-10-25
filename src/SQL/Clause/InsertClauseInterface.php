<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\Clause\Insert\ColumnsClauseInterface;
use FastOrm\SQL\ExpressionInterface;

interface InsertClauseInterface extends ExpressionInterface
{
    public function into($table): ColumnsClauseInterface;
}
