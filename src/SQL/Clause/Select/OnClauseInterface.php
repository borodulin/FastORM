<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\ExpressionInterface;

interface OnClauseInterface
{
    /**
     * @param ExpressionInterface|string $condition
     * @return FromClauseInterface
     */
    public function on($condition): FromClauseInterface;

    public function onColumns(string $column1, string $column2): FromClauseInterface;
}
