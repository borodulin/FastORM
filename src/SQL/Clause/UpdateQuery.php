<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\ConnectionInterface;
use FastOrm\EventDispatcherAwareInterface;
use FastOrm\EventDispatcherAwareTrait;
use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Update\ClauseContainer;
use FastOrm\SQL\Clause\Update\SetClauseInterface;
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

    public function update($table): SetClauseInterface
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
}
