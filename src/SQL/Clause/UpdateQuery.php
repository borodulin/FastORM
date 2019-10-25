<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\ConnectionInterface;
use FastOrm\EventDispatcherAwareInterface;
use FastOrm\EventDispatcherAwareTrait;
use FastOrm\InvalidArgumentException;
use FastOrm\PdoCommand\DbException;
use FastOrm\PdoCommand\StatementInterface;
use FastOrm\SQL\Clause\Update\ClauseContainer;
use FastOrm\SQL\Clause\Update\ConditionInterface;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class UpdateQuery implements
    UpdateClauseInterface,
    EventDispatcherAwareInterface,
    LoggerAwareInterface,
    CompilerAwareInterface,
    ExpressionBuilderInterface
{
    use EventDispatcherAwareTrait;
    use LoggerAwareTrait;
    use CompilerAwareTrait;

    /**
     * @var ClauseContainer
     */
    private $container;

    public function __construct(ConnectionInterface $connection)
    {
        $this->container = new ClauseContainer($connection);
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof UpdateQuery) {
            throw new InvalidArgumentException();
        }
        return $this->compiler->compile($expression->container);
    }

    public function update($table): UpdateClauseInterface
    {
        return $this->container->update($table);
    }

    public function __clone()
    {
        $this->container = clone $this->container;
    }

    public function __toString()
    {
        return (string)$this->container;
    }

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     * @throws DbException
     */
    public function count()
    {
        return $this->container->count();
    }

    /**
     * @param array $params
     * @return int
     * @throws DbException
     */
    public function execute(array $params = []): int
    {
        return $this->container->execute($params);
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

    public function set(array $set): UpdateClauseInterface
    {
        $this->container->set($set);
        return $this;
    }

    public function where(): ConditionInterface
    {
        return $this->container->where();
    }
}
