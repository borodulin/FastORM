<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;

class UnionClause extends AbstractClause
{
    /**
     * @var UnionItem[]
     */
    private $unions = [];

    public function addUnion(QueryInterface $query)
    {
        $this->unions[] = new UnionItem($query, false);
    }

    public function addUnionAll(QueryInterface $query)
    {
        $this->unions[] = new UnionItem($query, true);
    }

    /**
     * @return UnionItem[]
     */
    public function getUnions(): array
    {
        return $this->unions;
    }
}
