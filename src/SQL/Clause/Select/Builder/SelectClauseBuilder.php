<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select\Builder;

use FastOrm\SQL\Clause\Select\SelectClause;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionInterface;

class SelectClauseBuilder implements ExpressionInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var SelectClause
     */
    private $clause;

    public function __construct(SelectClause $clause)
    {
        $this->clause = $clause;
    }

    public function __toString(): string
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
            if ($column instanceof ExpressionInterface) {
                $sql = $this->compiler->compile($column);
                if (is_int($i)) {
                    $columns[$i] = $sql;
                } else {
                    $columns[$i] = "($sql) AS " . $this->compiler->quoteColumnName($i);
                }
            } elseif (is_string($i) && $i !== $column) {
                $column = $this->compiler->quoteColumnName($column);
                $columns[$i] = "$column AS " . $this->compiler->quoteColumnName($i);
            } elseif (strpos($column, '(') === false) {
                if (preg_match('/^(.*?)(?i:\s+as\s+|\s+)([\w\-_.]+)$/', $column, $matches)) {
                    $columns[$i] = $this->compiler->quoteColumnName($matches[1])
                        . ' AS ' . $this->compiler->quoteColumnName($matches[2]);
                } else {
                    $columns[$i] = $this->compiler->quoteColumnName($column);
                }
            }
        }

        return $select . ' ' . implode(', ', $columns);
    }
}
