<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\Command\CommandInterface;
use FastOrm\ConnectionInterface;
use FastOrm\SQL\Clause\FromClauseInterface;
use FastOrm\SQL\Clause\OffsetClauseInterface;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\SearchCondition\SearchConditionInterface;

trait QueryDecoratorTrait
{

    /**
     * @var QueryInterface
     */
    protected $query;

    public function __construct(QueryInterface $query)
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

    public function having(): SearchConditionInterface
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

    public function where(): SearchConditionInterface
    {
        return $this->query->where();
    }

    public function prepare(ConnectionInterface $connection): CommandInterface
    {
        return $this->query->prepare($connection);
    }
}
