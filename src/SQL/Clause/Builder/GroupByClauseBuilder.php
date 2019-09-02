<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\GroupByClause;
use FastOrm\SQL\ExpressionBuilderAwareInterface;
use FastOrm\SQL\ExpressionBuilderAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class GroupByClauseBuilder implements ExpressionBuilderInterface, ExpressionBuilderAwareInterface
{
    use ExpressionBuilderAwareTrait;


    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof GroupByClause) {
            throw new InvalidArgumentException();
        }
        $columns = $expression->getColumns();
        if (empty($columns)) {
            return '';
        }
        foreach ($columns as $i => $column) {
            if ($column instanceof ExpressionInterface) {
                $columns[$i] = $this->expressionBuilder->build($column);
            } elseif (strpos($column, '(') === false) {
                $columns[$i] = $column;
            }
        }

        return 'GROUP BY ' . implode(', ', $columns);
    }
}
