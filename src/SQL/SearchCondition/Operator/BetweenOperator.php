<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\BindParamsAwareInterface;
use FastOrm\SQL\BindParamsAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;

class BetweenOperator implements OperatorInterface, ExpressionBuilderInterface, BindParamsAwareInterface
{
    use BindParamsAwareTrait;

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
        $this->bindParams->bindValue($this->intervalStart, $paramStart);
        $this->bindParams->bindValue($this->intervalEnd, $paramEnd);
        return "$this->column BETWEEN :$paramStart AND :$paramEnd";
    }
}
