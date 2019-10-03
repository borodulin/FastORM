<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\ExpressionInterface;

class OrderByClause extends AbstractClause
{
    private $columns;

    public function addOrderBy($columns): void
    {
        if ($columns instanceof ExpressionInterface) {
            $this->columns[] = $columns;
        } elseif (is_string($columns)) {
            $columns = preg_split('/\s*,\s*/', trim($columns), -1, PREG_SPLIT_NO_EMPTY);
            foreach ($columns as $column) {
                if (preg_match('/^(.*?)\s+(asc|desc)$/i', $column, $matches)) {
                    $this->columns[$matches[1]] = strcasecmp($matches[2], 'desc') ? SORT_ASC : SORT_DESC;
                } else {
                    $this->columns[$column] = SORT_ASC;
                }
            }
        } elseif (is_array($columns)) {
            foreach ($columns as $key => $column) {
                if (is_int($key)) {
                    $this->columns[$column] = SORT_ASC;
                } else {
                    $this->columns[$key] = $column;
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function getColumns()
    {
        return $this->columns;
    }
}
