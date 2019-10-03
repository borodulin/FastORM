<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ParamsAwareInterface;
use FastOrm\SQL\ParamsAwareTrait;

class BetweenOperator implements
    OperatorInterface,
    ParamsAwareInterface,
    CompilerAwareInterface
{
    use ParamsAwareTrait, CompilerAwareTrait;

    private $column;
    private $intervalStart;
    private $intervalEnd;

    public function __construct($column, $intervalStart, $intervalEnd)
    {
        $this->column = $column;
        $this->intervalStart = $intervalStart;
        $this->intervalEnd = $intervalEnd;
    }

    public function __toString(): string
    {
        $paramStart = $this->params->bindValue($this->intervalStart);
        $paramEnd = $this->params->bindValue($this->intervalEnd);
        $column = $this->compiler->quoteColumnName($this->column);
        return "$column BETWEEN :$paramStart AND :$paramEnd";
    }
}
