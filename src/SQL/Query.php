<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\Command\Command;
use FastOrm\Command\CommandInterface;
use FastOrm\Command\Params;
use FastOrm\ConnectionInterface;
use FastOrm\EventDispatcherAwareInterface;
use FastOrm\EventDispatcherAwareTrait;
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
use FastOrm\SQL\SearchCondition\ConditionInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

/**
 * Class Query
 * @package FastOrm\SQL
 */
class Query implements
    OffsetClauseInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface,
    EventDispatcherAwareInterface,
    LoggerAwareInterface
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

    public function from($from): FromClauseInterface
    {
        return $this->fromClause->addFrom($from);
    }

    public function groupBy($columns): QueryInterface
    {
        $this->groupByClause->addGroupBy($columns);
        return $this;
    }

    public function having(): ConditionInterface
    {
        return $this->havingClause->getCondition();
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

    public function where(): ConditionInterface
    {
        return $this->whereClause->getCondition();
    }

    public function prepare(ConnectionInterface $connection): CommandInterface
    {
        $params = new Params();
        $compiler = $connection->getDriver()->createCompiler($params);
        $sql = $compiler->compile($this);
        $command = new Command($connection->getPDO(), $sql, $params);
        $this->logger && $command->setLogger($this->logger);
        $this->eventDispatcher && $command->setEventDispatcher($this->eventDispatcher);
        return $command;
    }

    public function build(): string
    {
        return implode(' ', array_filter([
            $this->compiler->compile($this->selectClause),
            $this->compiler->compile($this->fromClause),
            $this->compiler->compile($this->whereClause),
            $this->compiler->compile($this->groupByClause),
            $this->compiler->compile($this->havingClause),
            $this->compiler->compile($this->unionClause),
            $this->compiler->compile($this->orderByClause),
            $this->compiler->compile($this->limitClause),
        ]));
    }
}
