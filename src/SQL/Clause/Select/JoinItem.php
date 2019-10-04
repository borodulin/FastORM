<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\ExpressionInterface;

class JoinItem implements ExpressionInterface
{
    private $join;
    private $joinType;
    private $on;
    private $alias;

    public function __construct($join, $joinType)
    {
        $this->join = $join;
        $this->joinType = $joinType;
    }

    public function setOn(string $condition): void
    {
        $this->on = $condition;
    }

    /**
     * @return mixed
     */
    public function getJoin()
    {
        return $this->join;
    }

    /**
     * @return mixed
     */
    public function getJoinType()
    {
        return $this->joinType;
    }

    /**
     * @return string
     */
    public function getOn(): string
    {
        return $this->on;
    }

    /**
     * @param $alias
     */
    public function setAlias($alias): void
    {
        $this->alias = $alias;
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }
}
