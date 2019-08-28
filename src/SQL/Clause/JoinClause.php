<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;

class JoinClause implements ClauseInterface
{
    use ClauseTrait {
        ClauseTrait::__construct as private clauseTraitConstruct;
    }

    private $joins;

    public function __construct(QueryInterface $query)
    {
        $this->clauseTraitConstruct($query);
        $this->joins = [];
    }

    public function addJoin($join, $joinType): OnClauseInterface
    {
        $onClause = new OnClause($this->query, $join, $joinType);
        $this->joins[] = $onClause;
        return $onClause;
    }
}
