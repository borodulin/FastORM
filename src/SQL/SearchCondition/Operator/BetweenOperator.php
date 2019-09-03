<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\ParamsBinderAwareInterface;
use FastOrm\SQL\ParamsBinderAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;

class BetweenOperator implements OperatorInterface, ExpressionBuilderInterface, ParamsBinderAwareInterface
{
    use ParamsBinderAwareTrait;

    private $column;
    private $intervalStart;
    private $intervalEnd;

    public function __construct($column, $intervalStart, $intervalEnd)
    {
        $this->column = $column;
        $this->intervalStart = $intervalStart;
        $this->intervalEnd = $intervalEnd;
    }

    public function build(): string
    {
        $this->paramsBinder->bindValue($this->intervalStart, $paramStart);
        $this->paramsBinder->bindValue($this->intervalEnd, $paramEnd);
        return "$this->column BETWEEN :$paramStart AND :$paramEnd";
    }
}
