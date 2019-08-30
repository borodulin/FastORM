<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\ConnectionInterface;
use FastOrm\Driver\BindParamsInterface;
use FastOrm\SQL\Clause\FromClause;
use FastOrm\SQL\Clause\GroupByClause;
use FastOrm\SQL\Clause\HavingClause;
use FastOrm\SQL\Clause\JoinClause;
use FastOrm\SQL\Clause\LimitClause;
use FastOrm\SQL\Clause\OrderByClause;
use FastOrm\SQL\Clause\SelectClause;
use FastOrm\SQL\Clause\UnionClause;
use FastOrm\SQL\Clause\WhereClause;

class QueryBuilder implements BuilderInterface
{
    /**
     * @var ConnectionInterface
     */
    private $connection;
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
     * @var WhereClause
     */
    private $whereClause;
    /**
     * @var GroupByClause
     */
    private $groupByClause;
    /**
     * @var HavingClause
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
     * @var LimitClause
     */
    private $limitClause;

    public function __construct(
        ConnectionInterface $connection,
        SelectClause $selectClause,
        FromClause $fromClause,
        JoinClause $joinClause,
        WhereClause $whereClause,
        GroupByClause $groupByClause,
        HavingClause $havingClause,
        OrderByClause $orderByClause,
        UnionClause $unionClause,
        LimitClause $limitClause
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
        $this->limitClause = $limitClause;
    }

    public function getText(BindParamsInterface $bindParams): string
    {
        $clauseBuilderFactory = $this->connection->getBuilderFactory();
        return implode(' ', array_filter([
            $clauseBuilderFactory->build($this->selectClause)->getText(),
            $clauseBuilderFactory->build($this->fromClause)->getText(),
            $clauseBuilderFactory->build($this->joinClause)->getText(),
            $clauseBuilderFactory->build($this->whereClause)->getText(),
            $clauseBuilderFactory->build($this->groupByClause)->getText(),
            $clauseBuilderFactory->build($this->havingClause)->getText(),
            $clauseBuilderFactory->build($this->unionClause)->getText(),
            $clauseBuilderFactory->build($this->orderByClause)->getText(),
            $clauseBuilderFactory->build($this->limitClause)->getText(),
        ]));
    }
}
