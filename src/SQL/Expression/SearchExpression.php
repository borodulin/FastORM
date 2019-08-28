<?php

declare(strict_types=1);

namespace FastOrm\SQL\Expression;

use FastOrm\SQL\Clause\ClauseInterface;
use FastOrm\SQL\Operator\BetweenColumnsOperator;
use FastOrm\SQL\Operator\BetweenOperator;
use FastOrm\SQL\Operator\CompareOperator;
use FastOrm\SQL\Operator\CompoundInterface;
use FastOrm\SQL\Operator\EqualOperator;
use FastOrm\SQL\Operator\ExistsOperator;
use FastOrm\SQL\Operator\ExpressionOperator;
use FastOrm\SQL\Operator\FilterHashConditionOperator;
use FastOrm\SQL\Operator\HashConditionOperator;
use FastOrm\SQL\Operator\InOperator;
use FastOrm\SQL\Operator\LikeOperator;
use FastOrm\SQL\Operator\Operator;
use FastOrm\SQL\Operator\OperatorInterface;
use FastOrm\SQL\Operator\OperatorListInterface;
use FastOrm\SQL\QueryInterface;
use SplStack;

class SearchExpression implements SearchExpressionInterface, ClauseInterface
{

    /**
     * @var bool
     */
    private $not;
    /**
     * @var SplStack
     */
    private $operators;
    /**
     * @var CompoundInterface
     */
    private $compound;

    public function __construct(CompoundInterface $compound)
    {
        $this->operators = new SplStack();
        $this->compound = $compound;
    }

    public function not(): OperatorListInterface
    {
        $this->not = true;
        return $this;
    }

    public function between($column, $intervalStart, $intervalEnd): CompoundInterface
    {
        return $this->addOperator(new BetweenOperator($column, $intervalStart, $intervalEnd));
    }

    public function betweenColumns($value, $intervalStartColumn, $intervalEndColumn): CompoundInterface
    {
        return $this->addOperator(new BetweenColumnsOperator($value, $intervalStartColumn, $intervalEndColumn));
    }

    public function exists(QueryInterface $query): CompoundInterface
    {
        return $this->addOperator(new ExistsOperator($query));
    }

    public function in($column, $values): CompoundInterface
    {
        return $this->addOperator(new InOperator($column, $values));
    }

    public function like($column, $values): CompoundInterface
    {
        return $this->addOperator(new LikeOperator($column, $values));
    }

    public function compare($column, $operator, $value): CompoundInterface
    {
        return $this->addOperator(new CompareOperator($column, $operator, $value));
    }

    public function equal($column, $value): CompoundInterface
    {
        return $this->addOperator(new EqualOperator($column, $value));
    }

    public function expression($expression, array $params = []): CompoundInterface
    {
        return $this->addOperator(new ExpressionOperator($expression, $params));
    }

    public function filterHashCondition(array $hash): CompoundInterface
    {
        return $this->addOperator(new FilterHashConditionOperator($hash));
    }

    public function hashCondition(array $hash): CompoundInterface
    {
        return $this->addOperator(new HashConditionOperator($hash));
    }

    protected function addOperator(OperatorInterface $operator): CompoundInterface
    {
        $this->operators->push(new Operator($operator, $this->not));
        $this->not = null;
        return $this->compound;
    }

    public function getQuery(): QueryInterface
    {
        // TODO: Implement getQuery() method.
    }
}
