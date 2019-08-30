<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\ConnectionAwareInterface;
use FastOrm\ConnectionAwareTrait;
use FastOrm\SQL\BuilderInterface;
use FastOrm\SQL\ExpressionInterface;

abstract class AbstractClauseBuilder implements BuilderInterface, ConnectionAwareInterface
{
    use ConnectionAwareTrait;

    protected function buildExpression(ExpressionInterface $expression): string
    {
        return $this->connection->buildExpression($expression);
    }
}
