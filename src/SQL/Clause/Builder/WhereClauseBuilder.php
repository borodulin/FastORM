<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\WhereClause;
use FastOrm\SQL\ExpressionBuilderAwareInterface;
use FastOrm\SQL\ExpressionBuilderAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class WhereClauseBuilder implements ExpressionBuilderInterface, ExpressionBuilderAwareInterface
{
    use ExpressionBuilderAwareTrait;

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof WhereClause) {
            throw new InvalidArgumentException();
        }
        $where = $this->expressionBuilder->build($expression->getCompound());

        return $where === '' ? '' : 'WHERE ' . $where;
    }
}
