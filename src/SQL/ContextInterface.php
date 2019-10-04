<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use Countable;
use FastOrm\ConnectionInterface;
use IteratorAggregate;

interface ContextInterface extends IteratorAggregate, Countable, ExpressionInterface
{
    public function getConnection(): ConnectionInterface;
}
