<?php

declare(strict_types=1);

namespace FastOrm\ORM;

use FastOrm\SQL\Clause\OnClauseInterface;
use FastOrm\SQL\QueryInterface;

interface EntityQueryInterface extends QueryInterface
{
    public function with($relation, $class): LinkInterface;

    public function joinWith($relation, $join, string $joinType = 'inner join'): OnClauseInterface;

    public function innerJoinWith($relation, $join): OnClauseInterface;

    public function leftJoinWith($relation, $join): OnClauseInterface;

    public function rightJoinWith($relation, $join): OnClauseInterface;
}
