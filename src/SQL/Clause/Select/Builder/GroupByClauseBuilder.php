<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select\Builder;

use FastOrm\SQL\Clause\Select\GroupByClause;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionInterface;

class GroupByClauseBuilder implements ExpressionInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var GroupByClause
     */
    private $clause;

    public function __construct(GroupByClause $clause)
    {
        $this->clause = $clause;
    }

    public function __toString(): string
    {
        $columns = $this->clause->getColumns();
        if (empty($columns)) {
            return '';
        }
        foreach ($columns as $i => $column) {
            if ($column instanceof ExpressionInterface) {
                $column = $this->compiler->compile($column);
            }
            $columns[$i] = $this->compiler->quoteColumnName($column);
        }

        return 'GROUP BY ' . implode(', ', $columns);
    }
}
