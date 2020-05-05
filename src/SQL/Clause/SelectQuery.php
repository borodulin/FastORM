<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause;

use Borodulin\ORM\ConnectionInterface;
use Borodulin\ORM\EventDispatcherAwareInterface;
use Borodulin\ORM\EventDispatcherAwareTrait;
use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\PdoCommand\DbException;
use Borodulin\ORM\PdoCommand\Fetch\FetchInterface;
use Borodulin\ORM\PdoCommand\StatementInterface;
use Borodulin\ORM\SQL\Clause\Select\ClauseContainer;
use Borodulin\ORM\SQL\Clause\Select\ConditionInterface;
use Borodulin\ORM\SQL\Clause\Select\FromClauseInterface;
use Borodulin\ORM\SQL\Clause\Select\OffsetClauseInterface;
use Borodulin\ORM\SQL\Clause\Select\SelectDistinctInterface;
use Borodulin\ORM\SQL\CompilerAwareInterface;
use Borodulin\ORM\SQL\CompilerAwareTrait;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Traversable;

/**
 * Class Query.
 */
class SelectQuery implements
    OffsetClauseInterface,
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

    public function select($columns): SelectDistinctInterface
    {
        return $this->container->select($columns);
    }

    public function from($from): FromClauseInterface
    {
        return $this->container->from($from);
    }

    public function groupBy($columns): SelectClauseInterface
    {
        return $this->container->groupBy($columns);
    }

    public function having(): ConditionInterface
    {
        return $this->container->having();
    }

    public function orderBy($columns): SelectClauseInterface
    {
        return $this->container->orderBy($columns);
    }

    public function limit(int $limit): OffsetClauseInterface
    {
        return $this->container->limit($limit);
    }

    public function offset(int $offset): SelectClauseInterface
    {
        return $this->container->offset($offset);
    }

    public function union(SelectClauseInterface $query): SelectClauseInterface
    {
        return $this->container->union($query);
    }

    public function unionAll(SelectClauseInterface $query): SelectClauseInterface
    {
        return $this->container->unionAll($query);
    }

    public function where(): ConditionInterface
    {
        return $this->container->where();
    }

    public function __toString()
    {
        return (string) $this->container;
    }

    public function getIterator(): Traversable
    {
        return $this->container->getIterator();
    }

    /**
     * @throws DbException
     */
    public function fetch(array $params = []): FetchInterface
    {
        return $this->container->fetch($params);
    }

    /**
     * @throws DbException
     */
    public function statement(array $options = []): StatementInterface
    {
        return $this->container->statement($options);
    }

    /**
     * Count elements of an object.
     *
     * @see https://php.net/manual/en/countable.count.php
     *
     * @return int The custom count as an integer.
     *             </p>
     *             <p>
     *             The return value is cast to an integer.
     *
     * @since 5.1.0
     */
    public function count()
    {
        return \count($this->container);
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof self) {
            throw new InvalidArgumentException();
        }

        return $this->compiler->compile($this->container);
    }

    public function __clone()
    {
        $this->container = clone $this->container;
    }

    public function toArray(): array
    {
        return $this->container->toArray();
    }
}
