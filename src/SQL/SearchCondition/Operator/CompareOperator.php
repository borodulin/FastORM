<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\BindParamsAwareInterface;
use FastOrm\SQL\BindParamsAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;

class CompareOperator implements OperatorInterface, BindParamsAwareInterface, ExpressionBuilderInterface
{
    use BindParamsAwareTrait;

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
        $this->bindParams->bindValue($this->value, $paramName);
        return "$this->column $this->operator :$paramName";
    }
}
