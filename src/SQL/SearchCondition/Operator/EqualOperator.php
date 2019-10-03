<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ContextInterface;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;


class EqualOperator extends AbstractOperator implements
    CompilerAwareInterface,
    ExpressionBuilderInterface
{
    use CompilerAwareTrait;

    private $column;
    private $value;

    public function __construct($column, $value, ContextInterface $context)
    {
        $this->column = $column;
        $this->value = $value;
        parent::__construct($context);
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof EqualOperator) {
            throw new InvalidArgumentException();
        }
        if ($expression->value instanceof ExpressionInterface || is_array($expression->value)) {
            return $this->compiler->compile(new InOperator($expression->column, $expression->value, $expression->context));
        }
        $paramName = $this->compiler->getContext()->getParams()->bindValue($expression->value);
        $column = $this->compiler->quoteColumnName($expression->column);
        return "$column = :$paramName";
    }
}
