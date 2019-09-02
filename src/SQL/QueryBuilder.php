<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\InvalidArgumentException;

class QueryBuilder extends Query implements ExpressionBuilderInterface, ExpressionBuilderAwareInterface
{
    use ExpressionBuilderAwareTrait;

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof Query) {
            throw new InvalidArgumentException();
        }
        return implode(' ', array_filter([
            $this->expressionBuilder->build($expression->selectClause),
            $this->expressionBuilder->build($expression->fromClause),
            $this->expressionBuilder->build($expression->joinClause),
            $this->expressionBuilder->build($expression->whereClause),
            $this->expressionBuilder->build($expression->groupByClause),
            $this->expressionBuilder->build($expression->havingClause),
            $this->expressionBuilder->build($expression->unionClause),
            $this->expressionBuilder->build($expression->orderByClause),
            $this->expressionBuilder->build($expression->limitClause),
        ]));
    }
}
