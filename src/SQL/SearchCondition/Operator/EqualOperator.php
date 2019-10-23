<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class EqualOperator implements
    OperatorInterface,
    CompilerAwareInterface,
    ExpressionBuilderInterface
{
    use CompilerAwareTrait;

    private $column;
    private $value;

    public function __construct(string $column, $value)
    {
        $this->column = $column;
        $this->value = $value;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof EqualOperator) {
            throw new InvalidArgumentException();
        }
        if ($expression->value instanceof ExpressionInterface || is_array($expression->value)) {
            return $this->compiler->compile(new InOperator(
                $expression->column,
                $expression->value
            ));
        }
        $paramName = $this->compiler->getParams()->bindValue($expression->value);
        $column = $this->compiler->quoteColumnName($expression->column);
        return "$column = :$paramName";
    }
}
