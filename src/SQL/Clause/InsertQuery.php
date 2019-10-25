<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\ConnectionInterface;
use FastOrm\EventDispatcherAwareInterface;
use FastOrm\EventDispatcherAwareTrait;
use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Insert\ClauseContainer;
use FastOrm\SQL\Clause\Insert\ColumnsClauseInterface;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class InsertQuery implements
    InsertClauseInterface,
    EventDispatcherAwareInterface,
    LoggerAwareInterface,
    CompilerAwareInterface,
    ExpressionBuilderInterface
{
    use EventDispatcherAwareTrait;
    use LoggerAwareTrait;
    use CompilerAwareTrait;

    /**
     * @var ConnectionInterface
     */
    private $connection;
    /**
     * @var ClauseContainer
     */
    private $container;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
        $this->container = new ClauseContainer($connection);
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof SelectQuery) {
            throw new InvalidArgumentException();
        }
        return $this->compiler->compile($this->container);
    }

    public function into($table): ColumnsClauseInterface
    {
        return $this->container->into($table);
    }

    public function __clone()
    {
        $this->container = clone $this->container;
    }
}
