<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\ConnectionInterface;
use FastOrm\QueryBuilder;
use FastOrm\Schema\Command;
use FastOrm\Schema\CommandFetchInterface;
use FastOrm\SQL\Clause\AliasClauseInterface;
use FastOrm\SQL\Clause\FromClause;
use FastOrm\SQL\Clause\GroupByClause;
use FastOrm\SQL\Clause\JoinClause;
use FastOrm\SQL\Clause\OffsetClauseInterface;
use FastOrm\SQL\Clause\OnClauseInterface;
use FastOrm\SQL\Clause\OrderByClause;
use FastOrm\SQL\Clause\SelectClause;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\Clause\UnionClause;
use FastOrm\SQL\Expression\SearchExpression;
use FastOrm\SQL\Expression\SearchExpressionInterface;
use FastOrm\SQL\Operator\CompoundInterface;

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
     * @var SearchExpressionInterface
     */
    private $having;
    /**
     * @var int
     */
    private $limit;
    /**
     * @var int
     */
    private $offset;
    /**
     * @var OrderByClause
     */
    private $orderBy;
    /**
     * @var SearchExpressionInterface
     */
    private $where;
    /**
     * @var SearchExpressionInterface
     */
    private $activeSearchExpression;
    /**
     * @var UnionClause
     */
    private $union;
    /**
     * @var JoinClause
     */
    private $join;

    public function __construct()
    {
        $this->select = new SelectClause($this);
        $this->from = new FromClause($this);
        $this->join = new JoinClause($this);
        $this->where = new SearchExpression($this);
        $this->groupBy = new GroupByClause($this);
        $this->having = new SearchExpression($this);
        $this->orderBy = new OrderByClause($this);
        $this->union = new UnionClause($this);
    }

    public function and(): SearchExpressionInterface
    {
        return $this->activeSearchExpression;
    }

    public function or(): SearchExpressionInterface
    {
        return $this->activeSearchExpression;
    }

    public function select($columns): SelectClauseInterface
    {
        $this->select->addColumns($columns);
        return $this;
    }

    public function distinct(): QueryInterface
    {
        $this->select->distinct();
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

    public function having(): SearchExpressionInterface
    {
        return $this->activeSearchExpression = $this->having;
    }

    public function orderBy($columns): QueryInterface
    {
        $this->orderBy->addOrderBy($columns);
        return $this;
    }

    public function limit($limit): OffsetClauseInterface
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset(int $offset): QueryInterface
    {
        $this->offset = $offset;
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

    public function where(): SearchExpressionInterface
    {
        return $this->activeSearchExpression = $this->where;
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

    public function prepare(ConnectionInterface $connection, array $params = []): CommandFetchInterface
    {
        $queryBuilder = new QueryBuilder();
        $sql = $queryBuilder->getSQL();
        return new Command($connection, $sql, $params);
    }
}
