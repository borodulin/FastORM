<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition;

use FastOrm\SQL\QueryInterface;
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

class SearchCondition implements SearchConditionInterface
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
        return $this->setOperator(new BetweenOperator($column, $intervalStart, $intervalEnd));
    }

    public function betweenColumns($value, $intervalStartColumn, $intervalEndColumn): CompoundInterface
    {
        return $this->setOperator(new BetweenColumnsOperator($value, $intervalStartColumn, $intervalEndColumn));
    }

    public function exists(QueryInterface $query): CompoundInterface
    {
        return $this->setOperator(new ExistsOperator($query));
    }

    public function in($column, $values): CompoundInterface
    {
        return $this->setOperator(new InOperator($column, $values));
    }

    public function like($column, $values): CompoundInterface
    {
        return $this->setOperator(new LikeOperator($column, $values));
    }

    public function compare($column, $operator, $value): CompoundInterface
    {
        return $this->setOperator(new CompareOperator($column, $operator, $value));
    }

    public function equal($column, $value): CompoundInterface
    {
        return $this->setOperator(new EqualOperator($column, $value));
    }

    public function expression($expression, array $params = []): CompoundInterface
    {
        return $this->setOperator(new ExpressionOperator($expression, $params));
    }

    public function filterHashCondition(array $hash): CompoundInterface
    {
        return $this->setOperator(new FilterHashConditionOperator($hash));
    }

    public function hashCondition(array $hash): CompoundInterface
    {
        return $this->setOperator(new HashConditionOperator($hash));
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
}
