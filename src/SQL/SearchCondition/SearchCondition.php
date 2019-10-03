<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition;

use FastOrm\SQL\Clause\SelectInterface;
use FastOrm\SQL\ContextInterface;
use FastOrm\SQL\HasContextInterface;
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
use FastOrm\SQL\SearchCondition\Operator\OperatorInterface;
use FastOrm\SQL\SearchCondition\Operator\OperatorListInterface;

class SearchCondition implements ConditionInterface, HasContextInterface
{
    /**
     * @var bool
     */
    private $not = false;
    /**
     * @var OperatorInterface
     */
    private $operator;
    /**
     * @var Compound
     */
    private $compound;

    public function __construct(Compound $compound)
    {
        $this->compound = $compound;
    }

    public function not(): OperatorListInterface
    {
        $this->not = true;
        return $this;
    }

    public function between($column, $intervalStart, $intervalEnd): CompoundInterface
    {
        return $this->setOperator(new BetweenOperator(
            $column,
            $intervalStart,
            $intervalEnd,
            $this->compound->getQuery()
        ));
    }

    public function betweenColumns($value, $intervalStartColumn, $intervalEndColumn): CompoundInterface
    {
        return $this->setOperator(new BetweenColumnsOperator(
            $value,
            $intervalStartColumn,
            $intervalEndColumn,
            $this->compound->getQuery()
        ));
    }

    public function exists(SelectInterface $query): CompoundInterface
    {
        return $this->setOperator(new ExistsOperator($query, $this->compound->getQuery()));
    }

    public function in($column, $values): CompoundInterface
    {
        return $this->setOperator(new InOperator($column, $values, $this->compound->getQuery()));
    }

    public function like($column, $values): CompoundInterface
    {
        return $this->setOperator(new LikeOperator($column, $values, $this->compound->getQuery()));
    }

    public function compare($column, $operator, $value): CompoundInterface
    {
        return $this->setOperator(new CompareOperator(
            $column,
            $operator,
            $value,
            $this->compound->getQuery()
        ));
    }

    public function equal($column, $value): CompoundInterface
    {
        return $this->setOperator(new EqualOperator($column, $value, $this->compound->getQuery()));
    }

    public function expression($expression, array $params = []): CompoundInterface
    {
        return $this->setOperator(new ExpressionOperator($expression, $params, $this->compound->getQuery()));
    }

    public function filterHashCondition(array $hash): CompoundInterface
    {
        return $this->setOperator(new FilterHashConditionOperator($hash, $this->compound->getQuery()));
    }

    public function hashCondition(array $hash): CompoundInterface
    {
        return $this->setOperator(new HashConditionOperator($hash, $this->compound->getQuery()));
    }

    private function setOperator(OperatorInterface $operator): Compound
    {
        $this->operator = $operator;
        return $this->compound;
    }

    /**
     * @return OperatorInterface
     */
    public function getOperator(): ?OperatorInterface
    {
        return $this->operator;
    }

    /**
     * @return bool
     */
    public function isNot(): bool
    {
        return $this->not;
    }

    /**
     * @return Compound
     */
    public function getCompound(): Compound
    {
        return $this->compound;
    }

    public function __toString()
    {
        return (string)$this->compound->getQuery();
    }

    public function getContext(): ContextInterface
    {
        return $this->compound->getContext();
    }
}
