<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\Command\ParamsBinderAwareInterface;
use FastOrm\Command\ParamsBinderAwareTrait;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class CompareOperator implements
    OperatorInterface,
    ParamsBinderAwareInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface
{
    use ParamsBinderAwareTrait, CompilerAwareTrait;

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
        if ($this->value instanceof ExpressionInterface) {
            $this->value = $this->compiler->compile($this->value);
        }
        $this->paramsBinder->bindValue($this->value, $paramName);
        $column = $this->compiler->quoteColumnName($this->column);
        return "$column $this->operator :$paramName";
    }
}
