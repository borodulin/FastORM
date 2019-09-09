<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\Command\Command;
use FastOrm\Command\CommandInterface;
use FastOrm\ConnectionInterface;
use FastOrm\SQL\Clause\FromClause;
use FastOrm\SQL\Clause\FromClauseInterface;
use FastOrm\SQL\Clause\GroupByClause;
use FastOrm\SQL\Clause\HavingClause;
use FastOrm\SQL\Clause\LimitClause;
use FastOrm\SQL\Clause\OffsetClauseInterface;
use FastOrm\SQL\Clause\OrderByClause;
use FastOrm\SQL\Clause\SelectClause;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\Clause\UnionClause;
use FastOrm\SQL\Clause\WhereClause;
use FastOrm\SQL\SearchCondition\SearchConditionInterface;

/**
 * Class Query
 * @package FastOrm\SQL
 */
class Query implements
    OffsetClauseInterface
{
    /**
     * @var SelectClause
     */
    protected $selectClause;
    /**
     * @var FromClause
     */
    protected $fromClause;
    /**
     * @var GroupByClause
     */
    protected $groupByClause;
    /**
     * @var HavingClause
     */
    protected $havingClause;
    /**
     * @var LimitClause
     */
    protected $limitClause;
    /**
     * @var OrderByClause
     */
    protected $orderByClause;
    /**
     * @var WhereClause
     */
    protected $whereClause;
    /**
     * @var UnionClause
     */
    protected $unionClause;

    public function __construct()
    {
        $this->selectClause = new SelectClause($this);
        $this->fromClause = new FromClause($this);
        $this->whereClause = new WhereClause($this);
        $this->groupByClause = new GroupByClause($this);
        $this->havingClause = new HavingClause($this);
        $this->orderByClause = new OrderByClause($this);
        $this->unionClause = new UnionClause($this);
        $this->limitClause = new LimitClause($this);
    }

    public function select($columns): SelectClauseInterface
    {
        $this->selectClause->addColumns($columns);
        return $this->selectClause;
    }

    public function distinct(): QueryInterface
    {
        $this->selectClause->setDistinct(true);
        return $this;
    }

    public function from($from): FromClauseInterface
    {
        return $this->fromClause->addFrom($from);
    }

    public function groupBy($columns): QueryInterface
    {
        $this->groupByClause->addGroupBy($columns);
        return $this;
    }

    public function having(): SearchConditionInterface
    {
        return $this->havingClause->getSearchCondition();
    }

    public function orderBy($columns): QueryInterface
    {
        $this->orderByClause->addOrderBy($columns);
        return $this;
    }

    public function limit(int $limit): OffsetClauseInterface
    {
        $this->limitClause->setLimit($limit);
        return $this;
    }

    public function offset(int $offset): QueryInterface
    {
        $this->limitClause->setOffset($offset);
        return $this;
    }

    public function union(QueryInterface $query): QueryInterface
    {
        $this->unionClause->addUnion($query);
        return $this;
    }

    public function unionAll(QueryInterface $query): QueryInterface
    {
        $this->unionClause->addUnionAll($query);
        return $this;
    }

    public function where(): SearchConditionInterface
    {
        return $this->whereClause->getSearchCondition();
    }

    public function prepare(ConnectionInterface $connection): CommandInterface
    {
        $command = new Command($connection->getPDO());
        $compiler = $connection->getDriver()->createCompiler($command);
        $sql = $compiler->compile($this);
        $command->setSql($sql);
        return $command;
    }
}
