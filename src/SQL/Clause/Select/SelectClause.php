<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\SelectInterface;
use FastOrm\SQL\ExpressionInterface;

class SelectClause extends AbstractClause implements SelectClauseInterface
{
    /**
     * @var bool
     */
    private $distinct = false;
    private $columns = [];
    /**
     * @var string
     */
    private $option;

    public function addColumns($columns): void
    {
        if ($columns instanceof ExpressionInterface) {
            $this->columns[] = $columns;
        } elseif (!is_array($columns)) {
            $columns = preg_split('/\s*,\s*/', trim($columns), -1, PREG_SPLIT_NO_EMPTY);
        }
        foreach ($columns as $columnAlias => $columnDefinition) {
            if (is_string($columnAlias)) {
                // Already in the normalized format, good for them
                $this->columns[$columnAlias] = $columnDefinition;
                continue;
            }
            if (is_string($columnDefinition)) {
                if (preg_match('/^(.*?)(?i:\s+as\s+|\s+)([\w\-_.]+)$/', $columnDefinition, $matches) &&
                    !preg_match('/^\d+$/', $matches[2]) &&
                    strpos($matches[2], '.') === false
                ) {
                    // Using "columnName as alias" or "columnName alias" syntax
                    $this->columns[$matches[2]] = $matches[1];
                    continue;
                }
                if (strpos($columnDefinition, '(') === false) {
                    // Normal column name, just alias it to itself to ensure it's not selected twice
                    $this->columns[$columnDefinition] = $columnDefinition;
                    continue;
                }
            }
            // Either a string calling a function, DB expression, or sub-query
            $this->columns[] = $columnDefinition;
        }
    }

    /**
     * @return bool
     */
    public function isDistinct(): bool
    {
        return $this->distinct;
    }

    /**
     * @param bool $distinct
     */
    public function setDistinct(bool $distinct): void
    {
        $this->distinct = $distinct;
    }

    /**
     * @return string
     */
    public function getOption(): ?string
    {
        return $this->option;
    }

    /**
     * @param string $option
     */
    public function setOption(string $option): void
    {
        $this->option = $option;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    public function distinct(): SelectInterface
    {
        $this->distinct = true;
        return $this->query;
    }
}
