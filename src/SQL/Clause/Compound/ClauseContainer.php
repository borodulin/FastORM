<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Compound;

use FastOrm\ConnectionInterface;
use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Operator\BetweenColumnsOperator;
use FastOrm\SQL\Clause\Operator\BetweenOperator;
use FastOrm\SQL\Clause\Operator\CompareColumnsOperator;
use FastOrm\SQL\Clause\Operator\CompareOperator;
use FastOrm\SQL\Clause\Operator\EqualOperator;
use FastOrm\SQL\Clause\Operator\ExistsOperator;
use FastOrm\SQL\Clause\Operator\ExpressionOperator;
use FastOrm\SQL\Clause\Operator\FilterHashConditionOperator;
use FastOrm\SQL\Clause\Operator\HashConditionOperator;
use FastOrm\SQL\Clause\Operator\InOperator;
use FastOrm\SQL\Clause\Operator\LikeOperator;
use FastOrm\SQL\Clause\SelectClauseInterface;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class ClauseContainer implements
    ConditionInterface,
    CompoundInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var ConnectionInterface
     */
    protected $connection;
    /**
     * @var Compound
     */
    protected $compound;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
        $this->compound = new Compound($connection);
    }

    public function getCompound(): Compound
    {
        return $this->compound;
    }


    public function not(): OperatorListInterface
    {
        $this->getCompound()->getCompoundItem()->not();
        return $this;
    }

    public function between(string $column, $intervalStart, $intervalEnd): CompoundInterface
    {
        $this->getCompound()
            ->setOperator(new BetweenOperator($column, $intervalStart, $intervalEnd));
        return $this;
    }

    public function betweenColumns($value, string $intervalStartColumn, string $intervalEndColumn): CompoundInterface
    {
        $this->getCompound()
            ->setOperator(new BetweenColumnsOperator($value, $intervalStartColumn, $intervalEndColumn));
        return $this;
    }

    public function exists(SelectClauseInterface $query): CompoundInterface
    {
        $this->getCompound()
            ->setOperator(new ExistsOperator($query));
        return $this;
    }

    public function in(string $column, $values): CompoundInterface
    {
        $this->getCompound()
            ->setOperator(new InOperator($column, $values));
        return $this;
    }

    public function like(string $column, $values): CompoundInterface
    {
        $this->getCompound()
            ->setOperator(new LikeOperator($column, $values));
        return $this;
    }

    public function compare(string $column, string $operator, $value): CompoundInterface
    {
        $this->getCompound()
            ->setOperator(new CompareOperator($column, $operator, $value));
        return $this;
    }

    public function compareColumns(string $column1, string $operator, string $column2): CompoundInterface
    {
        $this->getCompound()
            ->setOperator(new CompareColumnsOperator($column1, $operator, $column2));
        return $this;
    }

    public function equal(string $column, $value): CompoundInterface
    {
        $this->getCompound()
            ->setOperator(new EqualOperator($column, $value));
        return $this;
    }

    public function expression($expression, array $params = []): CompoundInterface
    {
        $this->getCompound()
            ->setOperator(new ExpressionOperator($expression, $params));
        return $this;
    }

    public function filterHashCondition(array $hash): CompoundInterface
    {
        $this->getCompound()
            ->setOperator(new FilterHashConditionOperator($hash));
        return $this;
    }

    public function hashCondition(array $hash): CompoundInterface
    {
        $this->getCompound()
            ->setOperator(new HashConditionOperator($hash));
        return $this;
    }

    public function and(): ConditionInterface
    {
        $this->getCompound()->and();
        return $this;
    }

    public function or(): ConditionInterface
    {
        $this->getCompound()->or();
        return $this;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof ClauseContainer) {
            throw new InvalidArgumentException();
        }
        return $this->compiler->compile($this->compound);
    }
}
