<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

/**
 * Class BetweenColumnsOperator
 * @package FastOrm\SQL\SearchCondition\Operator
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
    /**
     * @var bool
     */
    private $not;

    public function __construct($value, $intervalStartColumn, $intervalEndColumn)
    {
        $this->value = $value;
        $this->intervalStartColumn = $intervalStartColumn;
        $this->intervalEndColumn = $intervalEndColumn;
    }

    public function setNot(bool $value): void
    {
        $this->not = $value;
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof BetweenColumnsOperator) {
            throw new InvalidArgumentException();
        }
        $paramName = $this->compiler->getParams()->bindValue($expression->value);
        $intervalStartColumn = $this->compiler->quoteColumnName($expression->intervalStartColumn);
        $intervalEndColumn = $this->compiler->quoteColumnName($expression->intervalEndColumn);
        return ":$paramName BETWEEN $intervalStartColumn AND $intervalEndColumn";
    }
}
