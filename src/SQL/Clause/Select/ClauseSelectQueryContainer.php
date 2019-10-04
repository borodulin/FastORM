<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\ConnectionInterface;
use FastOrm\InvalidArgumentException;
use FastOrm\PdoCommand\DbException;
use FastOrm\PdoCommand\Fetch\CursorInterface;
use FastOrm\PdoCommand\Fetch\Fetch;
use FastOrm\PdoCommand\Fetch\FetchInterface;
use FastOrm\PdoCommand\Statement;
use FastOrm\PdoCommand\StatementInterface;
use FastOrm\SQL\Clause\SelectInterface;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ContextInterface;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\SearchCondition\Compound;
use FastOrm\SQL\SearchCondition\CompoundInterface;
use FastOrm\SQL\SearchCondition\ConditionInterface;
use FastOrm\SQL\SearchCondition\Operator\BetweenColumnsOperator;
use FastOrm\SQL\SearchCondition\Operator\BetweenOperator;
use FastOrm\SQL\SearchCondition\Operator\CompareOperator;
use FastOrm\SQL\SearchCondition\Operator\EqualOperator;
use FastOrm\SQL\SearchCondition\Operator\ExistsOperator;
use FastOrm\SQL\SearchCondition\Operator\ExpressionOperator;
use FastOrm\SQL\SearchCondition\Operator\FilterHashConditionOperator;
use FastOrm\SQL\SearchCondition\Operator\HashConditionOperator;
use FastOrm\SQL\SearchCondition\Operator\InOperator;
use FastOrm\SQL\SearchCondition\Operator\LikeOperator;
use FastOrm\SQL\SearchCondition\Operator\OperatorListInterface;

class ClauseSelectQueryContainer implements
    SelectInterface,
    SelectClauseInterface,
    FromClauseInterface,
    ConditionInterface,
    OffsetClauseInterface,
    JoinAliasClauseInterface,
    CompoundInterface,
    ContextInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface
{
    use CompilerAwareTrait;
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
     * @var ConnectionInterface
     */
    private $connection;
    /**
     * @var CursorInterface
     */
    private $iterator;
    /**
     * @var Compound
     */
    private $activeCompound;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
        $this->selectClause = new SelectClause();
        $this->fromClause = new FromClause($this);
        $this->joinClause = new JoinClause();
        $this->whereClause = new WhereClause($this);
        $this->groupByClause = new GroupByClause();
        $this->havingClause = new HavingClause($this);
        $this->orderByClause = new OrderByClause();
        $this->unionClause = new UnionClause();
        $this->limitClause = new LimitClause();
    }

    /**
     * @param array $options
     * @return StatementInterface
     * @throws DbException
     */
    public function statement(array $options = []): StatementInterface
    {
        $compiler = $this->connection->getDriver()->createCompiler();
        $sql = $compiler->compile($this);
        $statement = new Statement($this->connection->getPdo(), $sql, $options);
        $statement->prepare($compiler->getParams());
        return $statement;
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

    public function not(): OperatorListInterface
    {
        $this->activeCompound->getCondition()->not();
        return $this;
    }

    public function offset(int $offset): SelectInterface
    {
        $this->limitClause->setOffset($offset);
        return $this;
    }

    public function between($column, $intervalStart, $intervalEnd): CompoundInterface
    {
        $this->activeCompound->getCondition()
            ->setOperator(new BetweenOperator($column, $intervalStart, $intervalEnd));
        return $this;
    }

    public function betweenColumns($value, $intervalStartColumn, $intervalEndColumn): CompoundInterface
    {
        $this->activeCompound->getCondition()
            ->setOperator(new BetweenColumnsOperator($value, $intervalStartColumn, $intervalEndColumn));
        return $this;
    }

    public function exists(SelectInterface $query): CompoundInterface
    {
        $this->activeCompound->getCondition()
            ->setOperator(new ExistsOperator($query));
        return $this;
    }

    public function in($column, $values): CompoundInterface
    {
        $this->activeCompound->getCondition()
            ->setOperator(new InOperator($column, $values));
        return $this;
    }

    public function like($column, $values): CompoundInterface
    {
        $this->activeCompound->getCondition()
            ->setOperator(new LikeOperator($column, $values));
        return $this;
    }

    public function compare($column, $operator, $value): CompoundInterface
    {
        $this->activeCompound->getCondition()
            ->setOperator(new CompareOperator($column, $operator, $value));
        return $this;
    }

    public function equal($column, $value): CompoundInterface
    {
        $this->activeCompound->getCondition()
            ->setOperator(new EqualOperator($column, $value));
        return $this;
    }

    public function expression($expression, array $params = []): CompoundInterface
    {
        $this->activeCompound->getCondition()
            ->setOperator(new ExpressionOperator($expression, $params));
        return $this;
    }

    public function filterHashCondition(array $hash): CompoundInterface
    {
        $this->activeCompound->getCondition()
            ->setOperator(new FilterHashConditionOperator($hash));
        return $this;
    }

    public function hashCondition(array $hash): CompoundInterface
    {
        $this->activeCompound->getCondition()
            ->setOperator(new HashConditionOperator($hash));
        return $this;
    }

    public function distinct(): SelectInterface
    {
        $this->selectClause->setDistinct(true);
        return $this;
    }

    public function select($columns): SelectClauseInterface
    {
        $this->selectClause->addColumns($columns);
        return $this;
    }

    public function from($from): FromClauseInterface
    {
        $this->fromClause->addFrom($from);
        return $this;
    }

    public function groupBy($columns): SelectInterface
    {
        $this->groupByClause->addGroupBy($columns);
        return $this;
    }

    public function having(): ConditionInterface
    {
        $this->activeCompound = $this->havingClause;
        return $this;
    }

    public function limit(int $limit): OffsetClauseInterface
    {
        $this->limitClause->setLimit($limit);
        return $this;
    }

    public function orderBy($columns): SelectInterface
    {
        $this->orderByClause->addOrderBy($columns);
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
        $this->activeCompound = $this->whereClause;
        return $this;
    }

    /**
     * @param array $params
     * @return FetchInterface
     * @throws DbException
     */
    public function fetch(array $params = []): FetchInterface
    {
        $statement = $this->statement();
        $statement->prepare($params);
        return new Fetch($statement);
    }

    public function setIterator(CursorInterface $cursor): SelectInterface
    {
        $this->iterator = $cursor;
        return $this;
    }

    /**
     * @return CursorInterface
     * @throws DbException
     */
    public function getIterator()
    {
        return $this->iterator ?: (new Fetch($this->statement()))->cursor();
    }

    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
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
        return count($this->fetch()->column());
    }

    public function on(string $condition): FromClauseInterface
    {
        $this->joinClause->getJoin()->setOn($condition);
        return $this;
    }

    public function alias($alias): OnClauseInterface
    {
        $this->joinClause->getJoin()->setAlias($alias);
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

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof ClauseSelectQueryContainer) {
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

    /**
     * @return Compound
     */
    public function getActiveCompound(): Compound
    {
        return $this->activeCompound;
    }

    /**
     * @param Compound $activeCompound
     */
    public function setActiveCompound(Compound $activeCompound): void
    {
        $this->activeCompound = $activeCompound;
    }

    public function __clone()
    {
        $this->selectClause = clone $this->selectClause;
        $this->fromClause = clone $this->fromClause;
        $this->joinClause = clone $this->joinClause;
        $this->whereClause = clone $this->whereClause;
        $this->groupByClause = clone $this->groupByClause;
        $this->havingClause = clone $this->havingClause;
        $this->orderByClause = clone $this->orderByClause;
        $this->unionClause = clone $this->unionClause;
        $this->limitClause = clone $this->limitClause;
    }
}