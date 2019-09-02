<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Builder;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\ExpressionBuilderAwareInterface;
use FastOrm\SQL\ExpressionBuilderAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\SearchCondition\Operator\NotOperatorInterface;
use FastOrm\SQL\SearchCondition\SearchCondition;

class SearchConditionBuilder implements ExpressionBuilderInterface, ExpressionBuilderAwareInterface
{
    use ExpressionBuilderAwareTrait;

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof SearchCondition) {
            throw new InvalidArgumentException();
        }
        if (!$operator = $expression->getOperator()) {
            return '';
        }
        $text = '';
        if ($operator instanceof NotOperatorInterface) {
            $operator->setNot($expression->isNot());
        } else {
            $text = $expression->isNot() ? 'NOT ' : '';
        }
        return $text .  $this->expressionBuilder->build($operator);
    }
}
