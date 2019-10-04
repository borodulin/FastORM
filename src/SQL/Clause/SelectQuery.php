<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\ConnectionInterface;
use FastOrm\EventDispatcherAwareInterface;
use FastOrm\EventDispatcherAwareTrait;
use FastOrm\InvalidArgumentException;
use FastOrm\PdoCommand\DbException;
use FastOrm\PdoCommand\Fetch\CursorInterface;
use FastOrm\PdoCommand\Fetch\FetchInterface;
use FastOrm\PdoCommand\StatementInterface;
use FastOrm\SQL\Clause\Select\ClauseSelectQueryContainer;
use FastOrm\SQL\Clause\Select\FromClauseInterface;
use FastOrm\SQL\Clause\Select\OffsetClauseInterface;
use FastOrm\SQL\Clause\Select\SelectClauseInterface;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ContextInterface;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;
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
    ContextInterface,
    LoggerAwareInterface,
    CompilerAwareInterface,
    ExpressionBuilderInterface
{
    use EventDispatcherAwareTrait, LoggerAwareTrait, CompilerAwareTrait;

    /**
     * @var ConnectionInterface
     */
    private $connection;
    /**
     * @var ClauseSelectQueryContainer
     */
    private $container;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
        $this->container = new ClauseSelectQueryContainer($connection);
    }

    public function select($columns): SelectClauseInterface
    {
        return $this->container->select($columns);
    }

    public function from($from): FromClauseInterface
    {
        return $this->container->from($from);
    }

    public function groupBy($columns): SelectInterface
    {
        return $this->container->groupBy($columns);
    }

    public function having(): ConditionInterface
    {
        return $this->container->having();
    }

    public function orderBy($columns): SelectInterface
    {
        return $this->container->orderBy($columns);
    }

    public function limit(int $limit): OffsetClauseInterface
    {
        return $this->container->limit($limit);
    }

    public function offset(int $offset): SelectInterface
    {
        return $this->container->offset($offset);
    }

    public function union(SelectInterface $query): SelectInterface
    {
        return $this->container->union($query);
    }

    public function unionAll(SelectInterface $query): SelectInterface
    {
        return $this->container->unionAll($query);
    }

    public function where(): ConditionInterface
    {
        return $this->container->where();
    }

    public function __toString()
    {
        return (string)$this->container;
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
        return $this->container->getIterator();
    }

    /**
     * @param array $params
     * @return FetchInterface
     * @throws DbException
     */
    public function fetch(array $params = []): FetchInterface
    {
        return $this->container->fetch($params);
    }

    /**
     * @param CursorInterface $iterator
     * @return SelectInterface
     */
    public function setIterator(CursorInterface $iterator): SelectInterface
    {
        return $this->container->setIterator($iterator);
    }

    /**
     * @param array $options
     * @return StatementInterface
     * @throws DbException
     */
    public function statement(array $options = []): StatementInterface
    {
        return $this->container->statement($options);
    }

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->container);
    }

    public function getConnection(): ConnectionInterface
    {
        return $this->container->getConnection();
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof SelectQuery) {
            throw new InvalidArgumentException();
        }
        return $this->compiler->compile($this->container);
    }
}
