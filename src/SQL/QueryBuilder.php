<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\ConnectionInterface;
use FastOrm\SQL\Clause\FromClause;
use FastOrm\SQL\Clause\GroupByClause;
use FastOrm\SQL\Clause\JoinClause;
use FastOrm\SQL\Clause\OrderByClause;
use FastOrm\SQL\Clause\SelectClause;
use FastOrm\SQL\Clause\UnionClause;
use FastOrm\SQL\Expression\SearchExpression;

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
    /**
     * @var ConnectionInterface
     */
    private $connection;

    public function __construct(
        ConnectionInterface $connection,
        SelectClause $selectClause,
        FromClause $fromClause,
        JoinClause $joinClause,
        SearchExpression $whereClause,
        GroupByClause $groupByClause,
        SearchExpression $havingClause,
        OrderByClause $orderByClause,
        UnionClause $unionClause
    ) {
        $this->connection = $connection;
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
        $clauseBuilderFactory = $this->connection->createClauseBuilderFactory();
        return implode(' ', array_filter([
            $clauseBuilderFactory->build($this->selectClause)->getSql(),
            $clauseBuilderFactory->build($this->fromClause)->getSql(),
            $clauseBuilderFactory->build($this->joinClause)->getSql(),
            $clauseBuilderFactory->build($this->whereClause)->getSql(),
            $clauseBuilderFactory->build($this->groupByClause)->getSql(),
            $clauseBuilderFactory->build($this->havingClause)->getSql(),
            $clauseBuilderFactory->build($this->unionClause)->getSql(),
            $clauseBuilderFactory->build($this->orderByClause)->getSql(),
        ]));
    }
}
