<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select\Builder;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Select\OrderByClause;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class OrderByClauseBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof OrderByClause) {
            throw new InvalidArgumentException();
        }
        $columns = $expression->getColumns();
        if (empty($columns)) {
            return '';
        }
        $orders = [];
        foreach ($columns as $name => $direction) {
            if ($direction instanceof ExpressionInterface) {
                $orders[] = $this->compiler->compile($direction);
            } else {
                $name = $this->compiler->quoteColumnName($name);
                $orders[] = $name.(SORT_DESC === $direction ? ' DESC' : '');
            }
        }

        return 'ORDER BY '.implode(', ', $orders);
    }
}
