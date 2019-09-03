<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\ParamsBinderAwareInterface;
use FastOrm\SQL\ParamsBinderAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;

class BetweenColumnsOperator implements NotOperatorInterface, ExpressionBuilderInterface, ParamsBinderAwareInterface
{
    use ParamsBinderAwareTrait;

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
        return ":$paramName BETWEEN $this->intervalStartColumn AND $this->intervalEndColumn";
    }
}
