<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\Command\ParamsBinderAwareInterface;
use FastOrm\Command\ParamsBinderAwareTrait;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class EqualOperator implements
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
        if ($this->value instanceof ExpressionInterface) {
            $this->value = $this->compiler->compile($this->value);
        }
        $this->paramsBinder->bindValue($this->value, $paramName);
        $column = $this->compiler->quoteColumnName($this->column);
        return "$column = :$paramName";
    }
}
