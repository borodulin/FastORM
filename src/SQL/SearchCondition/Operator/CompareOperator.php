<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\Command\ParamsAwareInterface;
use FastOrm\Command\ParamsAwareTrait;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class CompareOperator implements
    OperatorInterface,
    ParamsAwareInterface,
    ExpressionBuilderInterface,
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

    public function build(): string
    {
        if ($this->value instanceof ExpressionInterface) {
            $this->value = $this->compiler->compile($this->value);
        }
        $paramName = $this->params->bindValue($this->value);
        $column = $this->compiler->quoteColumnName($this->column);
        return "$column $this->operator :$paramName";
    }
}
