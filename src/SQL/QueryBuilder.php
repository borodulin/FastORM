<?php

declare(strict_types=1);

namespace FastOrm;

use FastOrm\SQL\Clause\FromClause;
use FastOrm\SQL\Clause\GroupByClause;
use FastOrm\SQL\Clause\JoinClause;
use FastOrm\SQL\Clause\OrderByClause;
use FastOrm\SQL\Clause\SelectClause;
use FastOrm\SQL\Clause\UnionClause;
use FastOrm\SQL\Expression\SearchExpression;
use FastOrm\SQL\QueryBuilderInterface;

class QueryBuilder implements QueryBuilderInterface
{
    /**
     * @var SelectClause
     */
    private $selectClause;
    /**
     * @var FromClause
     */
    private $fromClause;
    /**
     * @var JoinClause
     */
    private $joinClause;
    /**
     * @var SearchExpression
     */
    private $whereClause;
    /**
     * @var GroupByClause
     */
    private $groupByClause;
    /**
     * @var SearchExpression
     */
    private $havingClause;
    /**
     * @var OrderByClause
     */
    private $orderByClause;
    /**
     * @var UnionClause
     */
    private $unionClause;

    public function __construct(
        SelectClause $selectClause,
        FromClause $fromClause,
        JoinClause $joinClause,
        SearchExpression $whereClause,
        GroupByClause $groupByClause,
        SearchExpression $havingClause,
        OrderByClause $orderByClause,
        UnionClause $unionClause
    ) {

        $this->selectClause = $selectClause;
        $this->fromClause = $fromClause;
        $this->joinClause = $joinClause;
        $this->whereClause = $whereClause;
        $this->groupByClause = $groupByClause;
        $this->havingClause = $havingClause;
        $this->orderByClause = $orderByClause;
        $this->unionClause = $unionClause;
    }

    public function getSQL(): string
    {
        return implode(' ', array_filter([
            $this->selectClause->buildClause(),
            $this->fromClause->buildClause(),
            $this->joinClause->buildClause(),
            $this->whereClause->buildClause(),
            $this->groupByClause->buildClause(),
            $this->havingClause->buildClause(),
            $this->unionClause->buildClause(),
            $this->orderByClause->buildClause(),
        ]));
    }
}
