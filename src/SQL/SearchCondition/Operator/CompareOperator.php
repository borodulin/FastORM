<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ContextInterface;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class CompareOperator extends AbstractOperator implements
    CompilerAwareInterface,
    ExpressionBuilderInterface
{
    use CompilerAwareTrait;

    private $column;
    private $operator;
    private $value;

    public function __construct($column, $operator, $value, ContextInterface $context)
    {
        $this->column = $column;
        $this->operator = $operator;
        $this->value = $value;
        parent::__construct($context);
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof CompareOperator) {
            throw new InvalidArgumentException();
        }
        if ($expression->value instanceof ExpressionInterface) {
            $expression->value = $this->compiler->compile($expression->value);
        }
        $paramName = $this->compiler->getContext()->getParams()->bindValue($expression->value);
        $column = $this->compiler->quoteColumnName($expression->column);
        return "$column $expression->operator :$paramName";
    }
}
