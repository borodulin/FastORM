<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\BindParamsAwareInterface;
use FastOrm\SQL\BindParamsAwareTrait;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class LikeOperator implements
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
        $value = $this->value;
        if ($value instanceof ExpressionInterface) {
            $value = $this->compiler->compile($this->value);
        }
        $value = "%$value%";
        $this->bindParams->bindValue($value, $paramName);
        return "$this->column LIKE :$paramName";
    }
}
