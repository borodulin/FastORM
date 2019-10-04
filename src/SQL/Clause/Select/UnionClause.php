<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\SelectInterface;
use FastOrm\SQL\ExpressionInterface;

class UnionClause implements ExpressionInterface
{
    /**
     * @var UnionItem[]
     */
    private $unions = [];

    public function addUnion(SelectInterface $query)
    {
        $this->unions[] = new UnionItem($query, false);
    }

    public function addUnionAll(SelectInterface $query)
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