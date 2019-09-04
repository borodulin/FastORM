<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\SQL\Clause\GroupByClause;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class GroupByClauseBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
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

    public function build(): string
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
