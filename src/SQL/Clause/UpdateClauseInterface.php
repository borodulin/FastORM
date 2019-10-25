<?php

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\Clause\Update\SetClauseInterface;
use FastOrm\SQL\ExpressionInterface;

interface UpdateClauseInterface extends ExpressionInterface
{
    public function update($table): SetClauseInterface;
}
