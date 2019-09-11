<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\Command\CommandInterface;
use FastOrm\ConnectionInterface;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\Query;
use FastOrm\SQL\QueryInterface;
use FastOrm\SQL\SearchCondition\ConditionInterface;

abstract class AbstractClause implements
    ClauseInterface,
    QueryInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var Query
     */
    protected $query;

    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    public function getQuery(): QueryInterface
    {
        return $this->query;
    }

    public function select($columns): SelectClauseInterface
    {
        return $this->query->select($columns);
    }

    public function from($from): FromClauseInterface
    {
        return $this->query->from($from);
    }

    public function groupBy($columns): QueryInterface
    {
        return $this->query->groupBy($columns);
    }

    public function having(): ConditionInterface
    {
        return $this->query->having();
    }

    public function limit(int $limit): OffsetClauseInterface
    {
        return $this->query->limit($limit);
    }

    public function orderBy($columns): QueryInterface
    {
        return $this->query->orderBy($columns);
    }

    public function union(QueryInterface $query): QueryInterface
    {
        return $this->query->union($query);
    }

    public function unionAll(QueryInterface $query): QueryInterface
    {
        return $this->query->unionAll($query);
    }

    public function where(): ConditionInterface
    {
        return $this->query->where();
    }

    public function prepare(ConnectionInterface $connection): CommandInterface
    {
        return $this->query->prepare($connection);
    }

    public function build(): string
    {
        return $this->compiler->compile($this->query);
    }
}
