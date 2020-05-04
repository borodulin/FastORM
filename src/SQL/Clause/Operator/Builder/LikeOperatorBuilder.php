<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Operator\Builder;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\Operator\LikeOperator;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

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
            $like = ':'.$this->compiler->getParams()->bindValue($value);
        }
        $operator = $this->getOperator();
        $column = $expression->getColumn();
        $column = $this->compiler->quoteColumnName($column);

        return "$column $operator $like";
    }
}
