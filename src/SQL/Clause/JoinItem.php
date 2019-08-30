<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;

class JoinItem implements OnClauseInterface
{
    private $join;
    private $joinType;
    private $on;
    /**
     * @var QueryInterface
     */
    private $query;

    public function __construct(QueryInterface $query, $join, $joinType)
    {
        $this->join = $join;
        $this->joinType = $joinType;
        $this->query = $query;
    }

    public function on(string $condition): QueryInterface
    {
        $this->on = $condition;
        return $this->query;
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
}
