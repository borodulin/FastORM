<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\ConnectionInterface;
use FastOrm\Driver\Command;
use FastOrm\SQL\Clause\AbstractSearchConditionClause;
use FastOrm\SQL\Clause\AliasClauseInterface;
use FastOrm\SQL\Clause\FromClause;
use FastOrm\SQL\Clause\GroupByClause;
use FastOrm\SQL\Clause\HavingClause;
use FastOrm\SQL\Clause\JoinClause;
use FastOrm\SQL\Clause\LimitClause;
use FastOrm\SQL\Clause\OffsetClauseInterface;
use FastOrm\SQL\Clause\OnClauseInterface;
use FastOrm\SQL\Clause\OrderByClause;
use FastOrm\SQL\Clause\SelectClause;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\Clause\UnionClause;
use FastOrm\SQL\Clause\WhereClause;
use FastOrm\SQL\SearchCondition\CompoundInterface;
use FastOrm\SQL\SearchCondition\SearchConditionInterface;

/**
 * Class Query
 * @package FastOrm\SQL
 */
class Query implements
    CompoundInterface,
    SelectClauseInterface,
    AliasClauseInterface,
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
    /**
     * @var JoinClause
     */
    protected $joinClause;
    /**
     * @var AbstractSearchConditionClause
     */
    private $activeSearchConditionClause;

    public function __construct()
    {
        $this->selectClause = new SelectClause($this);
        $this->fromClause = new FromClause($this);
        $this->joinClause = new JoinClause($this);
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
        return $this;
    }

    public function distinct(): QueryInterface
    {
        $this->selectClause->setDistinct(true);
        return $this;
    }

    public function alias($alias): QueryInterface
    {
        $this->fromClause->setAlias($alias);
        return $this;
    }

    public function from($from): AliasClauseInterface
    {
        $this->fromClause->addFrom($from);
        return $this;
    }

    public function groupBy($columns): QueryInterface
    {
        $this->groupByClause->addGroupBy($columns);
        return $this;
    }

    public function having(): SearchConditionInterface
    {
        $this->activeSearchConditionClause = $this->havingClause;
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
        $this->activeSearchConditionClause = $this->whereClause;
        return $this->whereClause->getSearchCondition();
    }


    public function join($join, string $joinType = 'inner join'): OnClauseInterface
    {
        return $this->joinClause->addJoin($join, $joinType);
    }

    public function innerJoin($join): OnClauseInterface
    {
        return $this->joinClause->addJoin($join, 'inner join');
    }

    public function leftJoin($join): OnClauseInterface
    {
        return $this->joinClause->addJoin($join, 'left join');
    }

    public function rightJoin($join): OnClauseInterface
    {
        return $this->joinClause->addJoin($join, 'right join');
    }

    public function fullJoin($join): OnClauseInterface
    {
        return $this->joinClause->addJoin($join, 'full join');
    }

    public function prepare(ConnectionInterface $connection): CommandInterface
    {
        $command = new Command($connection->getPDO());
        $builder = $connection->getDriver()->createExpressionBuilder($command);
        $sql = $builder->build($this);
        $command->setSql($sql);
        return $command;
    }

    public function and(): SearchConditionInterface
    {
        return $this->activeSearchConditionClause->and();
    }

    public function or(): SearchConditionInterface
    {
        return $this->activeSearchConditionClause->or();
    }
}
