<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

use Borodulin\ORM\SQL\ExpressionInterface;

interface OnClauseInterface
{
    /**
     * @param ExpressionInterface|string $condition
     */
    public function on($condition): FromClauseInterface;

    public function onColumns(string $column1, string $column2): FromClauseInterface;
}
