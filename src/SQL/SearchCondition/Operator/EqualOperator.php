<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\Command\ParamsAwareInterface;
use FastOrm\Command\ParamsAwareTrait;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class EqualOperator implements
    OperatorInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface,
    ParamsAwareInterface
{
    use CompilerAwareTrait, ParamsAwareTrait;

    private $column;
    private $value;

    public function __construct($column, $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

    public function build(): string
    {
        if ($this->value instanceof ExpressionInterface || is_array($this->value)) {
            return $this->compiler->compile(new InOperator($this->column, $this->value));
        }
        $paramName = $this->params->bindValue($this->value);
        $column = $this->compiler->quoteColumnName($this->column);
        return "$column = :$paramName";
    }
}
