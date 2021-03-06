<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

use Borodulin\ORM\ConnectionInterface;
use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\PdoCommand\DbException;
use Borodulin\ORM\PdoCommand\Fetch\Fetch;
use Borodulin\ORM\PdoCommand\Fetch\FetchInterface;
use Borodulin\ORM\SQL\Clause\Compound\ClauseContainer as CompoundClauseContainer;
use Borodulin\ORM\SQL\Clause\HasStatementTrait;
use Borodulin\ORM\SQL\Clause\Operator\CompareColumnsOperator;
use Borodulin\ORM\SQL\Clause\SelectClauseInterface;
use Borodulin\ORM\SQL\CompilerAwareInterface;
use Borodulin\ORM\SQL\CompilerAwareTrait;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;

class ClauseContainer implements
    SelectClauseInterface,
    ConditionInterface,
    CompoundInterface,
    SelectDistinctInterface,
    FromClauseInterface,
    OffsetClauseInterface,
    JoinAliasClauseInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface
{
    use CompilerAwareTrait;
    use HasStatementTrait;

    /**
     * @var SelectClause
     */
    protected $selectClause;
    /**
     * @var FromClause
     */
    protected $fromClause;
    /**
     * @var JoinClause
     */
    private $joinClause;
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
     * @var CompoundClauseContainer
     */
    private $activeCompound;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
        $this->selectClause = new SelectClause();
        $this->fromClause = new FromClause($this);
        $this->joinClause = new JoinClause();
        $this->whereClause = new WhereClause($connection);
        $this->groupByClause = new GroupByClause();
        $this->havingClause = new HavingClause($connection);
        $this->orderByClause = new OrderByClause();
        $this->unionClause = new UnionClause();
        $this->limitClause = new LimitClause();
    }

    public function as($alias): FromClauseInterface
    {
        $this->fromClause->setAlias($alias);

        return $this;
    }

    public function __toString()
    {
        $compiler = $this->connection->getDriver()->createCompiler();

        return $compiler->compile($this);
    }

    public function join($join, string $joinType = 'INNER JOIN'): JoinAliasClauseInterface
    {
        $this->joinClause->addJoin($join, $joinType);

        return $this;
    }

    public function innerJoin($join): JoinAliasClauseInterface
    {
        $this->joinClause->addJoin($join, 'INNER JOIN');

        return $this;
    }

    public function leftJoin($join): JoinAliasClauseInterface
    {
        $this->joinClause->addJoin($join, 'LEFT JOIN');

        return $this;
    }

    public function rightJoin($join): JoinAliasClauseInterface
    {
        $this->joinClause->addJoin($join, 'RIGHT JOIN');

        return $this;
    }

    public function fullJoin($join): JoinAliasClauseInterface
    {
        $this->joinClause->addJoin($join, 'FULL JOIN');

        return $this;
    }

    public function offset(int $offset): SelectClauseInterface
    {
        $this->limitClause->setOffset($offset);

        return $this;
    }

    public function distinct(): SelectClauseInterface
    {
        $this->selectClause->setDistinct(true);

        return $this;
    }

    public function select($columns): SelectDistinctInterface
    {
        $this->selectClause->addColumns($columns);

        return $this;
    }

    public function from($from): FromClauseInterface
    {
        $this->fromClause->addFrom($from);

        return $this;
    }

    public function groupBy($columns): SelectClauseInterface
    {
        $this->groupByClause->addGroupBy($columns);

        return $this;
    }

    public function having(): ConditionInterface
    {
        $this->activeCompound = $this->havingClause->appendCompound();

        return $this;
    }

    public function limit(int $limit): OffsetClauseInterface
    {
        $this->limitClause->setLimit($limit);

        return $this;
    }

    public function orderBy($columns): SelectClauseInterface
    {
        $this->orderByClause->addOrderBy($columns);

        return $this;
    }

    public function union(SelectClauseInterface $query): SelectClauseInterface
    {
        $this->unionClause->addUnion($query);

        return $this;
    }

    public function unionAll(SelectClauseInterface $query): SelectClauseInterface
    {
        $this->unionClause->addUnionAll($query);

        return $this;
    }

    public function where(): ConditionInterface
    {
        $this->activeCompound = $this->whereClause->appendCompound();

        return $this;
    }

    /**
     * @throws DbException
     */
    public function fetch(array $params = []): FetchInterface
    {
        $statement = $this->statement();
        $statement->prepare($params);

        return new Fetch($statement);
    }

    public function getIterator(): \Traversable
    {
        return (new Fetch($this->statement()))->cursor();
    }

    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
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
     *
     * @throws DbException
     */
    public function count()
    {
        return \count($this->fetch()->column());
    }

    public function on($condition): FromClauseInterface
    {
        $this->joinClause->getJoin()->setOn($condition);

        return $this;
    }

    public function onColumns(string $column1, string $column2): FromClauseInterface
    {
        $this->joinClause->getJoin()->setOn(new CompareColumnsOperator($column1, '=', $column2));

        return $this;
    }

    public function alias($alias): OnClauseInterface
    {
        $this->joinClause->getJoin()->setAlias($alias);

        return $this;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof self) {
            throw new InvalidArgumentException();
        }

        return implode(' ', array_filter([
            $this->compiler->compile($expression->selectClause),
            $this->compiler->compile($expression->fromClause),
            $this->compiler->compile($expression->joinClause),
            $this->compiler->compile($expression->whereClause),
            $this->compiler->compile($expression->groupByClause),
            $this->compiler->compile($expression->havingClause),
            $this->compiler->compile($expression->unionClause),
            $this->compiler->compile($expression->orderByClause),
            $this->compiler->compile($expression->limitClause),
        ]));
    }

    public function __clone()
    {
        if ($this->activeCompound === $this->whereClause) {
            $this->whereClause = clone $this->whereClause;
            $this->activeCompound = $this->whereClause;
        } else {
            $this->whereClause = clone $this->whereClause;
        }
        if ($this->activeCompound === $this->havingClause) {
            $this->havingClause = clone $this->havingClause;
            $this->activeCompound = $this->havingClause;
        } else {
            $this->havingClause = clone $this->havingClause;
        }
        $this->selectClause = clone $this->selectClause;
        $this->fromClause = clone $this->fromClause;
        $this->joinClause = clone $this->joinClause;
        $this->groupByClause = clone $this->groupByClause;
        $this->orderByClause = clone $this->orderByClause;
        $this->unionClause = clone $this->unionClause;
        $this->limitClause = clone $this->limitClause;
    }

    public function not(): OperatorListInterface
    {
        $this->activeCompound->not();

        return $this;
    }

    public function between(string $column, $intervalStart, $intervalEnd): CompoundInterface
    {
        $this->activeCompound->between($column, $intervalStart, $intervalEnd);

        return $this;
    }

    public function betweenColumns($value, string $intervalStartColumn, string $intervalEndColumn): CompoundInterface
    {
        $this->activeCompound->betweenColumns($value, $intervalStartColumn, $intervalEndColumn);

        return $this;
    }

    public function exists(SelectClauseInterface $query): CompoundInterface
    {
        $this->activeCompound->exists($query);

        return $this;
    }

    public function in(string $column, $values): CompoundInterface
    {
        $this->activeCompound->in($column, $values);

        return $this;
    }

    public function like(string $column, $values): CompoundInterface
    {
        $this->activeCompound->like($column, $values);

        return $this;
    }

    public function compare(string $column, string $operator, $value): CompoundInterface
    {
        $this->activeCompound->compare($column, $operator, $value);

        return $this;
    }

    public function compareColumns(string $column1, string $operator, string $column2): CompoundInterface
    {
        $this->activeCompound->compareColumns($column1, $operator, $column2);

        return $this;
    }

    public function equal(string $column, $value): CompoundInterface
    {
        $this->activeCompound->equal($column, $value);

        return $this;
    }

    public function expression($expression, array $params = []): CompoundInterface
    {
        $this->activeCompound->expression($expression, $params);

        return $this;
    }

    public function filterHashCondition(array $hash): CompoundInterface
    {
        $this->activeCompound->filterHashCondition($hash);

        return $this;
    }

    public function hashCondition(array $hash): CompoundInterface
    {
        $this->activeCompound->hashCondition($hash);

        return $this;
    }

    public function and(): ConditionInterface
    {
        $this->activeCompound->and();

        return $this;
    }

    public function or(): ConditionInterface
    {
        $this->activeCompound->or();

        return $this;
    }

    public function toArray(): array
    {
        return iterator_to_array($this);
    }
}
