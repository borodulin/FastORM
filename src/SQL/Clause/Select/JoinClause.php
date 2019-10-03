<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

class JoinClause extends AbstractClause implements ClauseInterface
{

    private $joins = [];
    /**
     * @var FromClauseInterface
     */
    private $fromClause;

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

    /**
     * @param FromClauseInterface $fromClause
     */
    public function setFromClause(FromClauseInterface $fromClause): void
    {
        $this->fromClause = $fromClause;
    }
}
