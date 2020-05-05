<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

use Borodulin\ORM\SQL\ExpressionInterface;
use SplStack;

class JoinClause implements ExpressionInterface
{
    /**
     * @var SplStack
     */
    private $joins;

    public function __construct()
    {
        $this->joins = new SplStack();
    }

    public function addJoin($join, $joinType): void
    {
        $this->joins->add(0, new JoinItem($join, $joinType));
    }

    public function getJoins(): SplStack
    {
        return $this->joins;
    }

    public function getJoin(): JoinItem
    {
        return $this->joins->bottom();
    }

    public function __clone()
    {
        $this->joins = clone $this->joins;
    }
}
