<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\SQL\Clause\SelectClause;
use FastOrm\SQL\Query;

class SelectClauseBuilder extends AbstractClauseBuilder
{
    /**
     * @var SelectClause
     */
    private $clause;

    public function __construct(SelectClause $clause)
    {
        $this->clause = $clause;
    }

    public function getText(): string
    {
        $select = $this->clause->isDistinct() ? 'SELECT DISTINCT' : 'SELECT';
        if ($selectOption = $this->clause->getOption() !== null) {
            $select .= ' ' . $selectOption;
        }
        $columns = $this->clause->getColumns();
        if (empty($columns)) {
            return $select . ' *';
        }

        foreach ($columns as $i => $column) {
//            if ($column instanceof ExpressionInterface) {
//                if (is_int($i)) {
//                    $columns[$i] = $this->buildExpression($column, $params);
//                } else {
//                    $columns[$i] = $this->buildExpression($column, $params) . ' AS ' . $this->db->quoteColumnName($i);
//                }
//            } else
            if ($column instanceof Query) {
                $sql = $this->buildQuery($column);
                $columns[$i] = "($sql) AS " . $i;
            } elseif (is_string($i) && $i !== $column) {
//                if (strpos($column, '(') === false) {
//                }
                $columns[$i] = "$column AS " . $i;
            } elseif (strpos($column, '(') === false) {
                if (preg_match('/^(.*?)(?i:\s+as\s+|\s+)([\w\-_.]+)$/', $column, $matches)) {
                    $columns[$i] = $matches[1] . ' AS ' . $matches[2];
                } else {
                    $columns[$i] = $column;
                }
            }
        }

        return $select . ' ' . implode(', ', $columns);
    }

    private function buildQuery(Query $column)
    {
        // TODO
    }
}
