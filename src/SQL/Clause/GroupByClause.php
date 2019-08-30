<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

class GroupByClause extends AbstractClause
{
    private $columns;

    public function addGroupBy($columns): void
    {
        if (!empty($columns)) {
            if (is_array($columns)) {
                foreach ($columns as $column) {
                    $this->columns[] = $column;
                }
            } else {
                $this->columns[] = $columns;
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
