<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\SQL\Clause\OrderByClause;
use FastOrm\SQL\Expression\ExpressionInterface;

class OrderByClauseBuilder extends AbstractClauseBuilder
{
    /**
     * @var OrderByClause
     */
    private $clause;

    public function __construct(OrderByClause $clause)
    {
        $this->clause = $clause;
    }

    public function getText(): string
    {
        $columns = $this->clause->getColumns();
        if (empty($columns)) {
            return '';
        }
        $orders = [];
        foreach ($columns as $name => $direction) {
            if ($direction instanceof ExpressionInterface) {
//                $orders[] = $this->buildExpression($direction); TODO
            } else {
                $orders[] = $name . ($direction === SORT_DESC ? ' DESC' : '');
            }
        }

        return 'ORDER BY ' . implode(', ', $orders);
    }
}
