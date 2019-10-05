<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\ExpressionInterface;

class UnionClause implements ExpressionInterface
{
    /**
     * @var UnionItem[]
     */
    private $unions = [];

    public function addUnion(SelectClauseInterface $query)
    {
        $this->unions[] = new UnionItem($query, false);
    }

    public function addUnionAll(SelectClauseInterface $query)
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
