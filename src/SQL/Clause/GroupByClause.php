<?php

declare(strict_types=true);

namespace FastOrm\SQL\Clause;

class GroupByClause implements ClauseInterface
{
    use ClauseTrait;

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
}
