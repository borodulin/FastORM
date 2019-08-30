<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\ConnectionInterface;
use FastOrm\Driver\Command;
use FastOrm\Driver\CommandFetchInterface;
use FastOrm\Driver\CommandInterface;
use FastOrm\Driver\BindParamsInterface;
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
    private $select;
    /**
     * @var FromClause
     */
    private $from;
    /**
     * @var GroupByClause
     */
    private $groupBy;
    /**
     * @var HavingClause
     */
    private $having;
    /**
     * @var LimitClause
     */
    private $limit;
    /**
     * @var OrderByClause
     */
    private $orderBy;
    /**
     * @var WhereClause
     */
    private $where;
    /**
     * @var UnionClause
     */
    private $union;
    /**
     * @var JoinClause
     */
    private $join;
    /**
     * @var AbstractSearchConditionClause
     */
    private $activeSearchConditionClause;

    public function __construct()
    {
        $this->select = new SelectClause($this);
        $this->from = new FromClause($this);
        $this->join = new JoinClause($this);
        $this->where = new WhereClause($this);
        $this->groupBy = new GroupByClause($this);
        $this->having = new HavingClause($this);
        $this->orderBy = new OrderByClause($this);
        $this->union = new UnionClause($this);
        $this->limit = new LimitClause($this);
    }

    public function select($columns): SelectClauseInterface
    {
        $this->select->addColumns($columns);
        return $this;
    }

    public function distinct(): QueryInterface
    {
        $this->select->setDistinct(true);
        return $this;
    }

    public function alias($alias): QueryInterface
    {
        $this->from->setAlias($alias);
        return $this;
    }

    public function from($from): AliasClauseInterface
    {
        $this->from->addFrom($from);
        return $this;
    }

    public function groupBy($columns): QueryInterface
    {
        $this->groupBy->addGroupBy($columns);
        return $this;
    }

    public function having(): SearchConditionInterface
    {
        $this->activeSearchConditionClause = $this->having;
        return $this->having->getSearchCondition();
    }

    public function orderBy($columns): QueryInterface
    {
        $this->orderBy->addOrderBy($columns);
        return $this;
    }

    public function limit(int $limit): OffsetClauseInterface
    {
        $this->limit->setLimit($limit);
        return $this;
    }

    public function offset(int $offset): QueryInterface
    {
        $this->limit->setOffset($offset);
        return $this;
    }

    public function union(QueryInterface $query): QueryInterface
    {
        $this->union->addUnion($query);
        return $this;
    }

    public function unionAll(QueryInterface $query): QueryInterface
    {
        $this->union->addUnionAll($query);
        return $this;
    }

    public function where(): SearchConditionInterface
    {
        return $this->where->getSearchCondition();
    }


    public function join($join, string $joinType = 'inner join'): OnClauseInterface
    {
        return $this->join->addJoin($join, $joinType);
    }

    public function innerJoin($join): OnClauseInterface
    {
        return $this->join->addJoin($join, 'inner join');
    }

    public function leftJoin($join): OnClauseInterface
    {
        return $this->join->addJoin($join, 'left join');
    }

    public function rightJoin($join): OnClauseInterface
    {
        return $this->join->addJoin($join, 'right join');
    }

    public function fullJoin($join): OnClauseInterface
    {
        return $this->join->addJoin($join, 'full join');
    }

    public function prepare(ConnectionInterface $connection): CommandInterface
    {
        $queryBuilder = new QueryBuilder(
            $connection,
            $this->select,
            $this->from,
            $this->join,
            $this->where,
            $this->groupBy,
            $this->having,
            $this->orderBy,
            $this->union,
            $this->limit
        );
        $command = new Command($connection->getPDO());
        $sql = $queryBuilder->getText();
        return new Command($connection->getPDO(), $sql);
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
