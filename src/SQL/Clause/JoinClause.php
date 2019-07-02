<?php

declare(strict_types=true);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;
use SplStack;

class JoinClause implements ClauseInterface
{
    use ClauseTrait {
        ClauseTrait::__construct as private clauseTraitConstruct;
    }

    private $joins;

    public function __construct(QueryInterface $query)
    {
        $this->clauseTraitConstruct($query);
        $this->joins = new SplStack();
    }

    public function addJoin($join, $joinType): OnClauseInterface
    {
        $onClause = new OnClause($this->query, $join, $joinType);
        $this->joins->push($onClause);
        return $onClause;
    }
}
