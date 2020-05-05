<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause;

use Borodulin\ORM\ConnectionInterface;
use Borodulin\ORM\EventDispatcherAwareInterface;
use Borodulin\ORM\EventDispatcherAwareTrait;
use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\PdoCommand\DbException;
use Borodulin\ORM\PdoCommand\StatementInterface;
use Borodulin\ORM\SQL\Clause\Insert\ClauseContainer;
use Borodulin\ORM\SQL\Clause\Insert\ColumnsClauseInterface;
use Borodulin\ORM\SQL\CompilerAwareInterface;
use Borodulin\ORM\SQL\CompilerAwareTrait;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;
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

    public function __toString()
    {
        return (string) $this->container;
    }

    /**
     * @throws DbException
     */
    public function statement(array $options = []): StatementInterface
    {
        return $this->container->statement($options);
    }
}
