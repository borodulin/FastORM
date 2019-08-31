<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\Driver\DriverAwareInterface;
use FastOrm\Driver\DriverAwareTrait;
use FastOrm\SQL\BuilderInterface;
use FastOrm\SQL\ExpressionInterface;

abstract class AbstractClauseBuilder implements BuilderInterface, DriverAwareInterface
{
    use DriverAwareTrait;

    protected function buildExpression(ExpressionInterface $expression): string
    {
        return $this->driver->buildExpression($expression);
    }
}
