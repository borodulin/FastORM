<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\SQL\Clause\JoinClause;
use FastOrm\SQL\Clause\JoinItem;
use FastOrm\SQL\ExpressionBuilderAwareInterface;
use FastOrm\SQL\ExpressionBuilderAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class JoinClauseBuilder implements ExpressionBuilderInterface, ExpressionBuilderAwareInterface
{
    use ExpressionBuilderAwareTrait;

    /**
     * @var JoinClause
     */
    private $clause;

    public function __construct(JoinClause $clause)
    {
        $this->clause = $clause;
    }

    public function build(ExpressionInterface $expression): string
    {
        $joins = $this->clause->getJoins();
        if (empty($joins)) {
            return '';
        }

        $result = [];
        /** @var JoinItem $joinItem */
        foreach ($joins as $joinItem) {
            $joinType = $joinItem->getJoinType();
            $join = $joinItem->getJoin();
            if ($join instanceof ExpressionInterface) {
                $join = $this->expressionBuilder->build($join);
            }
            $on = $joinItem->getOn();
            $result[] = "$joinType $join ON $on";
        }

        return implode(' ', $joins);
    }
}
