<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;


use FastOrm\SQL\QueryInterface;

class OnClause implements OnClauseInterface
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

    public function on($condition): QueryInterface
    {
        $this->on = $condition;
        return $this->query;
    }
}
