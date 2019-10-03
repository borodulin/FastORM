<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\ConnectionInterface;
use FastOrm\EventDispatcherAwareInterface;
use FastOrm\EventDispatcherAwareTrait;
use FastOrm\PdoCommand\DbException;
use FastOrm\PdoCommand\Fetch\CursorInterface;
use FastOrm\PdoCommand\Fetch\Fetch;
use FastOrm\PdoCommand\Fetch\FetchInterface;
use FastOrm\PdoCommand\Statement;
use FastOrm\PdoCommand\StatementInterface;
use FastOrm\SQL\Clause\Select\FromClause;
use FastOrm\SQL\Clause\Select\FromClauseInterface;
use FastOrm\SQL\Clause\Select\GroupByClause;
use FastOrm\SQL\Clause\Select\HavingClause;
use FastOrm\SQL\Clause\Select\LimitClause;
use FastOrm\SQL\Clause\Select\OffsetClauseInterface;
use FastOrm\SQL\Clause\Select\OrderByClause;
use FastOrm\SQL\Clause\Select\SelectClause;
use FastOrm\SQL\Clause\Select\SelectClauseInterface;
use FastOrm\SQL\Clause\Select\UnionClause;
use FastOrm\SQL\Clause\Select\WhereClause;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\CompilerInterface;
use FastOrm\SQL\Params;
use FastOrm\SQL\SearchCondition\ConditionInterface;
use IteratorAggregate;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Traversable;

/**
 * Class Query
 * @package FastOrm\SQL
 */
class SelectQuery implements
    OffsetClauseInterface,
    CompilerAwareInterface,
    EventDispatcherAwareInterface,
    LoggerAwareInterface,
    IteratorAggregate
{
    use CompilerAwareTrait, EventDispatcherAwareTrait, LoggerAwareTrait;
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
     * @var ConnectionInterface
     */
    private $connection;

    private $iterator;

    public function __construct(ConnectionInterface $connection)
    {
        $this->selectClause = new SelectClause($this);
        $this->fromClause = new FromClause($this);
        $this->whereClause = new WhereClause($this);
        $this->groupByClause = new GroupByClause($this);
        $this->havingClause = new HavingClause($this);
        $this->orderByClause = new OrderByClause($this);
        $this->unionClause = new UnionClause($this);
        $this->limitClause = new LimitClause($this);
        $this->connection = $connection;
    }

    public function select($columns): SelectClauseInterface
    {
        $this->selectClause->addColumns($columns);
        return $this->selectClause;
    }

    public function from($from): FromClauseInterface
    {
        return $this->fromClause->addFrom($from);
    }

    public function groupBy($columns): SelectInterface
    {
        $this->groupByClause->addGroupBy($columns);
        return $this;
    }

    public function having(): ConditionInterface
    {
        return $this->havingClause->getCondition();
    }

    public function orderBy($columns): SelectInterface
    {
        $this->orderByClause->addOrderBy($columns);
        return $this;
    }

    public function limit(int $limit): OffsetClauseInterface
    {
        $this->limitClause->setLimit($limit);
        return $this;
    }

    public function offset(int $offset): SelectInterface
    {
        $this->limitClause->setOffset($offset);
        return $this;
    }

    public function union(SelectInterface $query): SelectInterface
    {
        $this->unionClause->addUnion($query);
        return $this;
    }

    public function unionAll(SelectInterface $query): SelectInterface
    {
        $this->unionClause->addUnionAll($query);
        return $this;
    }

    public function where(): ConditionInterface
    {
        return $this->whereClause->getCondition();
    }

    public function __toString()
    {
        $compiler = $this->connection->getDriver()->createCompiler(new Params());
        return $this->compileQuery($compiler);
    }

    private function compileQuery(CompilerInterface $compiler): string
    {
        return implode(' ', array_filter([
            $compiler->compile($this->selectClause),
            $compiler->compile($this->fromClause),
            $compiler->compile($this->whereClause),
            $compiler->compile($this->groupByClause),
            $compiler->compile($this->havingClause),
            $compiler->compile($this->unionClause),
            $compiler->compile($this->orderByClause),
            $compiler->compile($this->limitClause),
        ]));
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
        return $this->iterator ?: $this->fetch()->cursor();
    }

    /**
     * @param array $params
     * @return FetchInterface
     * @throws DbException
     */
    public function fetch(array $params = []): FetchInterface
    {
        return new Fetch($this->statement());
    }

    /**
     * @param CursorInterface $iterator
     * @return SelectInterface
     */
    public function setIterator(CursorInterface $iterator): SelectInterface
    {
        $this->iterator = $iterator;
        return $this;
    }

    /**
     * @param array $options
     * @return StatementInterface
     * @throws DbException
     */
    public function statement(array $options = []): StatementInterface
    {
        $params = new Params();
        $compiler = $this->connection->getDriver()->createCompiler($params);
        $sql = $this->compileQuery($compiler);
        $statement = new Statement($this->connection->getPdo(), $sql, $options);
        $statement->prepare($params->getParams());
        return $statement;
    }
}
