<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Operator;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class CompareColumnsOperator implements
    OperatorInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface
{
    use CompilerAwareTrait;

    private $column1;
    private $operator;
    private $column2;

    public function __construct(string $column1, string $operator, string $column2)
    {
        $this->column1 = $column1;
        $this->operator = $operator;
        $this->column2 = $column2;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof CompareColumnsOperator) {
            throw new InvalidArgumentException();
        }

        $column1 = $this->compiler->quoteColumnName($expression->column1);
        $column2 = $this->compiler->quoteColumnName($expression->column2);
        return "{$column1} {$this->operator} {$column2}";
    }
}
