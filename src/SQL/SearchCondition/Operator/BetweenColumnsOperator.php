<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\Command\ParamsBinderAwareInterface;
use FastOrm\Command\ParamsBinderAwareTrait;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;

class BetweenColumnsOperator implements
    NotOperatorInterface,
    ExpressionBuilderInterface,
    ParamsBinderAwareInterface,
    CompilerAwareInterface
{
    use ParamsBinderAwareTrait, CompilerAwareTrait;

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

    public function build(): string
    {
        $this->paramsBinder->bindValue($this->value, $paramName);
        $intervalStartColumn = $this->compiler->quoteColumnName($this->intervalStartColumn);
        $intervalEndColumn = $this->compiler->quoteColumnName($this->intervalEndColumn);
        return ":$paramName BETWEEN $intervalStartColumn AND $intervalEndColumn";
    }
}
