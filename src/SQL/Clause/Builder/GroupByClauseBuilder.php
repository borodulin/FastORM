<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\Driver\BindParamsInterface;
use FastOrm\SQL\Clause\GroupByClause;
use FastOrm\SQL\ExpressionInterface;

class GroupByClauseBuilder extends AbstractClauseBuilder
{

    /**
     * @var GroupByClause
     */
    private $clause;

    public function __construct(GroupByClause $clause)
    {
        $this->clause = $clause;
    }

    public function getText(): string
    {
        $columns = $this->clause->getColumns();
        if (empty($columns)) {
            return '';
        }
        foreach ($columns as $i => $column) {
            if ($column instanceof ExpressionInterface) {
                $columns[$i] = $this->buildExpression($column);
            } elseif (strpos($column, '(') === false) {
                $columns[$i] = $column;
            }
        }

        return 'GROUP BY ' . implode(', ', $columns);
    }
}
