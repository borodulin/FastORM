<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

class JoinItem implements JoinAliasClauseInterface
{
    private $join;
    private $joinType;
    private $on;
    private $alias;
    /**
     * @var FromClauseInterface
     */
    private $fromClause;

    public function __construct(FromClauseInterface $fromClause, $join, $joinType)
    {
        $this->join = $join;
        $this->joinType = $joinType;
        $this->fromClause = $fromClause;
    }

    public function on(string $condition): FromClauseInterface
    {
        $this->on = $condition;
        return $this->fromClause;
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

    public function alias($alias): OnClauseInterface
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }
}
