<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\BindParamsAwareInterface;
use FastOrm\SQL\BindParamsAwareTrait;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class EqualOperator implements
    OperatorInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface,
    BindParamsAwareInterface
{
    use CompilerAwareTrait, BindParamsAwareTrait;

    private $column;
    private $value;

    public function __construct($column, $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

    public function build(): string
    {
        if ($this->value instanceof ExpressionInterface) {
            $this->value = $this->compiler->compile($this->value);
        }
        $this->bindParams->bindValue($this->value, $paramName);
        return "$this->column = :$paramName";
    }
}
