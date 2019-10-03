<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\ParamsAwareInterface;
use FastOrm\SQL\ParamsAwareTrait;

class CompareOperator implements
    OperatorInterface,
    ParamsAwareInterface,
    CompilerAwareInterface
{
    use ParamsAwareTrait, CompilerAwareTrait;

    private $column;
    private $operator;
    private $value;

    public function __construct($column, $operator, $value)
    {
        $this->column = $column;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function __toString(): string
    {
        if ($this->value instanceof ExpressionInterface) {
            $this->value = $this->compiler->compile($this->value);
        }
        $paramName = $this->params->bindValue($this->value);
        $column = $this->compiler->quoteColumnName($this->column);
        return "$column $this->operator :$paramName";
    }
}
