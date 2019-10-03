<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\PdoCommand\DbException;
use FastOrm\PdoCommand\Fetch\CursorInterface;
use FastOrm\PdoCommand\Fetch\FetchInterface;
use FastOrm\PdoCommand\StatementInterface;
use FastOrm\SQL\Clause\SelectInterface;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\SearchCondition\ConditionInterface;
use Traversable;

abstract class AbstractClause implements ClauseInterface, SelectInterface
{
    /**
     * @var SelectQuery
     */
    protected $query;

    public function __construct(SelectQuery $query)
    {
        $this->query = $query;
    }

    public function getQuery(): SelectInterface
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

    public function groupBy($columns): SelectInterface
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

    public function orderBy($columns): SelectInterface
    {
        return $this->query->orderBy($columns);
    }

    public function union(SelectInterface $query): SelectInterface
    {
        return $this->query->union($query);
    }

    public function unionAll(SelectInterface $query): SelectInterface
    {
        return $this->query->unionAll($query);
    }

    public function where(): ConditionInterface
    {
        return $this->query->where();
    }

    /**
     * Retrieve an external iterator
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @throws DbException
     * @since 5.0.0
     */
    public function getIterator()
    {
        return $this->query->getIterator();
    }

    /**
     * @param array $options
     * @return StatementInterface
     * @throws DbException
     */
    public function statement(array $options = []): StatementInterface
    {
        return $this->query->statement($options);
    }

    /**
     * @param array $params
     * @return FetchInterface
     * @throws DbException
     */
    public function fetch(array $params = []): FetchInterface
    {
        return $this->query->fetch($params);
    }

    public function setIterator(CursorInterface $cursor): SelectInterface
    {
        return $this->query->setIterator($cursor);
    }

    public function __toString()
    {
        return (string)$this->query;
    }
}
