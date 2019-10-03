<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\SelectInterface;
use FastOrm\SQL\ExpressionInterface;
use IteratorAggregate;

interface ClauseInterface extends ExpressionInterface, IteratorAggregate
{
    public function getQuery(): SelectInterface;
}
