<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;

class JoinClause implements ClauseInterface
{

    private $joins = [];
    /**
     * @var FromClauseInterface
     */
    private $fromClause;

    public function __construct(FromClauseInterface $fromClause)
    {
        $this->fromClause = $fromClause;
    }

    public function addJoin($join, $joinType): JoinAliasClauseInterface
    {
        $onClause = new JoinItem($this->fromClause, $join, $joinType);
        $this->joins[] = $onClause;
        return $onClause;
    }

    /**
     * @return array
     */
    public function getJoins(): array
    {
        return $this->joins;
    }

    public function getQuery(): QueryInterface
    {
        return $this->fromClause;
    }
}
