<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

class JoinClause extends AbstractClause
{

    private $joins = [];

    public function addJoin($join, $joinType): OnClauseInterface
    {
        $onClause = new JoinItem($this->query, $join, $joinType);
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
}
