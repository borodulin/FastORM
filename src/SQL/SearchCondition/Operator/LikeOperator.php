<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\ParamsBinderAwareInterface;
use FastOrm\SQL\ParamsBinderAwareTrait;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class LikeOperator implements
    OperatorInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface,
    ParamsBinderAwareInterface
{
    use CompilerAwareTrait, ParamsBinderAwareTrait;

    private $column;
    private $value;

    public function __construct($column, $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

    public function build(): string
    {
        $value = $this->value;
        if ($value instanceof ExpressionInterface) {
            $value = $this->compiler->compile($this->value);
        }
        $value = "%$value%";
        $this->paramsBinder->bindValue($value, $paramName);
        return "$this->column LIKE :$paramName";
    }
}
