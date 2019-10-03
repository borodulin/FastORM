<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\ConnectionInterface;
use FastOrm\EventDispatcherAwareInterface;
use FastOrm\EventDispatcherAwareTrait;
use FastOrm\InvalidArgumentException;
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
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\Params;
use FastOrm\SQL\ParamsInterface;
use FastOrm\SQL\SearchCondition\ConditionInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Traversable;

/**
 * Class Query
 * @package FastOrm\SQL
 */
class SelectQuery implements
    OffsetClauseInterface,
    EventDispatcherAwareInterface,
    LoggerAwareInterface,
    ClauseContextInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface
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

    /**
     * @var Params
     */
    private $params;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
        $this->init();
    }

    protected function init()
    {
        $this->selectClause = new SelectClause($this);
        $this->fromClause = new FromClause($this);
        $this->whereClause = new WhereClause($this);
        $this->groupByClause = new GroupByClause($this);
        $this->havingClause = new HavingClause($this);
        $this->orderByClause = new OrderByClause($this);
        $this->unionClause = new UnionClause($this);
        $this->limitClause = new LimitClause($this);
        $this->params = new Params();
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
        $compiler = $this->connection->getDriver()->createCompiler($this);
        return $compiler->compile($this);
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
        $compiler = $this->connection->getDriver()->createCompiler($this);
        $sql = $compiler->compile($this);
        $statement = new Statement($this->connection->getPdo(), $sql, $options);
        $statement->prepare($this->params);
        return $statement;
    }

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @throws DbException
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->fetch()->column());
    }

    public function getParams(): ParamsInterface
    {
        return $this->params;
    }

    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof SelectQuery) {
            throw new InvalidArgumentException();
        }
        return implode(' ', array_filter([
            $this->compiler->compile($expression->selectClause),
            $this->compiler->compile($expression->fromClause),
            $this->compiler->compile($expression->whereClause),
            $this->compiler->compile($expression->groupByClause),
            $this->compiler->compile($expression->havingClause),
            $this->compiler->compile($expression->unionClause),
            $this->compiler->compile($expression->orderByClause),
            $this->compiler->compile($expression->limitClause),
        ]));
    }
}
