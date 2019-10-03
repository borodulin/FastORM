<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select\Builder;

use FastOrm\SQL\Clause\Select\OrderByClause;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionInterface;


class OrderByClauseBuilder implements ExpressionInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var OrderByClause
     */
    private $clause;

    public function __construct(OrderByClause $clause)
    {
        $this->clause = $clause;
    }

    public function __toString(): string
    {
        $columns = $this->clause->getColumns();
        if (empty($columns)) {
            return '';
        }
        $orders = [];
        foreach ($columns as $name => $direction) {
            if ($direction instanceof ExpressionInterface) {
                $orders[] = $this->compiler->compile($direction);
            } else {
                $name = $this->compiler->quoteColumnName($name);
                $orders[] = $name . ($direction === SORT_DESC ? ' DESC' : '');
            }
        }

        return 'ORDER BY ' . implode(', ', $orders);
    }
}
