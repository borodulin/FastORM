<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\SelectClause;
use FastOrm\SQL\ExpressionBuilderAwareInterface;
use FastOrm\SQL\ExpressionBuilderAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\Query;

class SelectClauseBuilder implements ExpressionBuilderInterface, ExpressionBuilderAwareInterface
{
    use ExpressionBuilderAwareTrait;


    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof SelectClause) {
            throw new InvalidArgumentException();
        }
        $select = $expression->isDistinct() ? 'SELECT DISTINCT' : 'SELECT';
        if ($selectOption = $expression->getOption() !== null) {
            $select .= ' ' . $selectOption;
        }
        $columns = $expression->getColumns();
        if (empty($columns)) {
            return $select . ' *';
        }

        foreach ($columns as $i => $column) {
            if ($column instanceof Query) {
                $sql = $this->expressionBuilder->build($column);
                $columns[$i] = "($sql) AS " . $i;
            } elseif ($column instanceof ExpressionInterface) {
                if (is_int($i)) {
                    $columns[$i] = $this->expressionBuilder->build($column);
                } else {
                    $columns[$i] = $this->expressionBuilder->build($column) . ' AS ' . $i;
                }
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
}
