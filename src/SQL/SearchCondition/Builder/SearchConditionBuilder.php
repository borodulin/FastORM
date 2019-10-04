<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Builder;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Select\ClauseSelectQueryContainer;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\SearchCondition\Compound;
use FastOrm\SQL\SearchCondition\Operator\ExpressionOperator;
use FastOrm\SQL\SearchCondition\Operator\NotOperatorInterface;
use FastOrm\SQL\SearchCondition\SearchCondition;

class SearchConditionBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

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
        if ($operator instanceof ExpressionOperator) {
            $expressionOperator = $operator->getExpression();
            if (is_callable($expressionOperator)) {
                $connection = $expression->getCompound()->getContainer()->getConnection();
                $container = new ClauseSelectQueryContainer($connection) ;
                $compound = new Compound($container);
                $container->setActiveCompound($compound);
                call_user_func($expressionOperator, $container);
                $operator->setExpression($compound);
            }
        }
        return $text .  $this->compiler->compile($operator);
    }
}
