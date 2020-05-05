<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

use Borodulin\ORM\SQL\Clause\SelectClauseInterface;
use Borodulin\ORM\SQL\ExpressionInterface;

class UnionClause implements ExpressionInterface
{
    /**
     * @var UnionItem[]
     */
    private $unions = [];

    public function addUnion(SelectClauseInterface $query): void
    {
        $this->unions[] = new UnionItem($query, false);
    }

    public function addUnionAll(SelectClauseInterface $query): void
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
