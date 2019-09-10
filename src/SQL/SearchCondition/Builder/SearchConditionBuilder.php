<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Builder;

use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\SearchCondition\Compound;
use FastOrm\SQL\SearchCondition\Operator\ExpressionOperator;
use FastOrm\SQL\SearchCondition\Operator\NotOperatorInterface;
use FastOrm\SQL\SearchCondition\SearchCondition;

class SearchConditionBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var SearchCondition
     */
    private $condition;

    public function __construct(SearchCondition $condition)
    {
        $this->condition = $condition;
    }

    public function build(): string
    {
        if (!$operator = $this->condition->getOperator()) {
            return '';
        }
        $text = '';
        if ($operator instanceof NotOperatorInterface) {
            $operator->setNot($this->condition->isNot());
        } else {
            $text = $this->condition->isNot() ? 'NOT ' : '';
        }
        if ($operator instanceof ExpressionOperator) {
            $expression = $operator->getExpression();
            if (is_callable($expression)) {
                $compound = new Compound($this->condition->getCompound()->getQuery());
                $expression = call_user_func($expression, $compound->getSearchCondition());
                $operator->setExpression($expression);
            }
        }
        return $text .  $this->compiler->compile($operator);
    }
}
