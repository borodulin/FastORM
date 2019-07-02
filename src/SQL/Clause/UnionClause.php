<?php

declare(strict_types=true);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\Operator\UnionOperator;
use FastOrm\SQL\QueryInterface;
use SplStack;

class UnionClause implements ClauseInterface
{
    /**
     * @var QueryInterface
     */
    private $query;
    /**
     * @var SplStack
     */
    private $unions;

    public function __construct(QueryInterface $query)
    {
        $this->query = $query;
        $this->unions = new SplStack();
    }

    public function addUnion(QueryInterface $query)
    {
        $this->unions->push(new UnionOperator($query, false));
    }

    public function addUnionAll(QueryInterface $query)
    {
        $this->unions->push(new UnionOperator($query, true));
    }

    public function getQuery(): QueryInterface
    {
        return $this->query;
    }
}
