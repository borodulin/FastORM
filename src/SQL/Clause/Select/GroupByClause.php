<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

use Borodulin\ORM\SQL\ExpressionInterface;

class GroupByClause implements ExpressionInterface
{
    private $columns;

    public function addGroupBy($columns): void
    {
        if (!empty($columns)) {
            if (\is_array($columns)) {
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
