<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\ParamsBinderAwareInterface;
use FastOrm\SQL\ParamsBinderAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;

class CompareOperator implements OperatorInterface, ParamsBinderAwareInterface, ExpressionBuilderInterface
{
    use ParamsBinderAwareTrait;

    private $column;
    private $operator;
    private $value;

    public function __construct($column, $operator, $value)
    {

        $this->column = $column;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function build(): string
    {
        $this->paramsBinder->bindValue($this->value, $paramName);
        return "$this->column $this->operator :$paramName";
    }
}
