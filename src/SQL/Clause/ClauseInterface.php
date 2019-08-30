<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\QueryInterface;

interface ClauseInterface extends ExpressionInterface
{
    public function getQuery(): QueryInterface;
}
