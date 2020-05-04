<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Operator;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

/**
 * Class BetweenColumnsOperator.
 */
class BetweenColumnsOperator implements
    OperatorInterface,
    NotOperatorInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface
{
    use CompilerAwareTrait;

    private $value;
    private $intervalStartColumn;
    private $intervalEndColumn;
    private $not = '';

    public function __construct($value, string $intervalStartColumn, string $intervalEndColumn)
    {
        $this->value = $value;
        $this->intervalStartColumn = $intervalStartColumn;
        $this->intervalEndColumn = $intervalEndColumn;
    }

    public function not(): void
    {
        $this->not = 'NOT ';
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof self) {
            throw new InvalidArgumentException();
        }
        $paramName = $this->compiler->getParams()->bindValue($expression->value);
        $intervalStartColumn = $this->compiler->quoteColumnName($expression->intervalStartColumn);
        $intervalEndColumn = $this->compiler->quoteColumnName($expression->intervalEndColumn);

        return ":$paramName {$this->not}BETWEEN $intervalStartColumn AND $intervalEndColumn";
    }
}
