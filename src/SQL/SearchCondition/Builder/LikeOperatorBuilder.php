<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Builder;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\SearchCondition\Operator\LikeOperator;

class LikeOperatorBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    protected function getOperator()
    {
        return 'LIKE';
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof LikeOperator) {
            throw new InvalidArgumentException();
        }

        $value = $expression->getValue();
        if ($value instanceof ExpressionInterface) {
            $like = $this->compiler->compile($value);
        } else {
            $value = "%$value%";
            $like = ':' . $this->compiler->getContext()->getParams()->bindValue($value);
        }
        $operator = $this->getOperator();
        $column = $expression->getColumn();
        return "$column $operator $like";
    }
}
