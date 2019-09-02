<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\HavingClause;
use FastOrm\SQL\ExpressionBuilderAwareInterface;
use FastOrm\SQL\ExpressionBuilderAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class HavingClauseBuilder implements ExpressionBuilderInterface, ExpressionBuilderAwareInterface
{
    use ExpressionBuilderAwareTrait;

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof HavingClause) {
            throw new InvalidArgumentException();
        }
        $having = $this->expressionBuilder->build($expression->getCompound());

        return $having === '' ? '' : 'HAVING ' . $having;
    }
}
