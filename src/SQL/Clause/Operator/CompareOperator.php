<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Operator;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class CompareOperator implements
    OperatorInterface,
    CompilerAwareInterface,
    ExpressionBuilderInterface
{
    use CompilerAwareTrait;

    private $column;
    private $operator;
    private $value;

    public function __construct(string $column, string $operator, $value)
    {
        $this->column = $column;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof self) {
            throw new InvalidArgumentException();
        }
        if ($expression->value instanceof ExpressionInterface) {
            $expression->value = $this->compiler->compile($expression->value);
        }
        $paramName = $this->compiler->getParams()->bindValue($expression->value);
        $column = $this->compiler->quoteColumnName($expression->column);

        return "$column $expression->operator :$paramName";
    }
}
