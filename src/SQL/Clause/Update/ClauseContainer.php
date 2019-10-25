<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Update;

use FastOrm\ConnectionInterface;
use FastOrm\InvalidArgumentException;
use FastOrm\PdoCommand\DbException;
use FastOrm\SQL\Clause\Compound\ClauseContainer as CompoundClauseContainer;
use FastOrm\SQL\Clause\HasStatementTrait;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\Clause\UpdateClauseInterface;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class ClauseContainer implements
    UpdateClauseInterface,
    SetClauseInterface,
    WhereClauseInterface,
    CompoundInterface,
    ConditionInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface
{
    use CompilerAwareTrait;
    use HasStatementTrait;

    /**
     * @var CompoundClauseContainer
     */
    private $whereClause;
    /**
     * @var array
     */
    private $set;
    /**
     * @var string
     */
    private $table;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
        $this->whereClause = new CompoundClauseContainer($connection);
    }

    public function update($table): SetClauseInterface
    {
        $this->table = $table;
        return $this;
    }

    public function set(array $set): WhereClauseInterface
    {
        $this->set = $set;
        return $this;
    }

    public function where(): ConditionInterface
    {
        $this->whereClause->appendCompound();
        return $this;
    }

    public function __clone()
    {
        $this->whereClause = clone $this->whereClause;
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
        return $this->execute();
    }

    /**
     * @param array $params
     * @return int
     * @throws DbException
     */
    public function execute(array $params = []): int
    {
        return $this->statement()->execute($params)->rowCount();
    }

    public function not(): OperatorListInterface
    {
        $this->whereClause->not();
        return $this;
    }

    public function between(string $column, $intervalStart, $intervalEnd): CompoundInterface
    {
        $this->whereClause->between($column, $intervalStart, $intervalEnd);
        return $this;
    }

    public function betweenColumns($value, string $intervalStartColumn, string $intervalEndColumn): CompoundInterface
    {
        $this->whereClause->betweenColumns($value, $intervalStartColumn, $intervalEndColumn);
        return $this;
    }

    public function exists(SelectClauseInterface $query): CompoundInterface
    {
        $this->whereClause->exists($query);
        return $this;
    }

    public function in(string $column, $values): CompoundInterface
    {
        $this->whereClause->in($column, $values);
        return $this;
    }

    public function like(string $column, $values): CompoundInterface
    {
        $this->whereClause->like($column, $values);
        return $this;
    }

    public function compare(string $column, string $operator, $value): CompoundInterface
    {
        $this->whereClause->compare($column, $operator, $value);
        return $this;
    }

    public function compareColumns(string $column1, string $operator, string $column2): CompoundInterface
    {
        $this->whereClause->compareColumns($column1, $operator, $column2);
        return $this;
    }

    public function equal(string $column, $value): CompoundInterface
    {
        $this->whereClause->equal($column, $value);
        return $this;
    }

    public function expression($expression, array $params = []): CompoundInterface
    {
        $this->whereClause->expression($expression, $params);
        return $this;
    }

    public function filterHashCondition(array $hash): CompoundInterface
    {
        $this->whereClause->filterHashCondition($hash);
        return $this;
    }

    public function hashCondition(array $hash): CompoundInterface
    {
        $this->whereClause->hashCondition($hash);
        return $this;
    }

    public function and(): ConditionInterface
    {
        $this->whereClause->and();
        return $this;
    }

    public function or(): ConditionInterface
    {
        $this->whereClause->or();
        return $this;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof ClauseContainer) {
            throw new InvalidArgumentException();
        }
        if ($expression->table instanceof ExpressionInterface) {
            $table = $this->compiler->compile($expression->table);
        } else {
            $table = $this->compiler->quoteTableName($this->table);
        }
        $where = $this->compiler->compile($expression->whereClause);
        $set = [];
        $params = $this->compiler->getParams();
        foreach ($expression->set as $key => $value) {
            $key = $this->compiler->quoteColumnName($key);
            if ($value instanceof ExpressionInterface) {
                $value = $this->compiler->compile($value);
                $set[] = "$key = $value";
            } else {
                $value = $params->bindValue($value);
                $set[] = "$key = :$value";
            }
        }
        $set = implode(',', $set);
        return "UPDATE $table SET $set WHERE $where";
    }
}
