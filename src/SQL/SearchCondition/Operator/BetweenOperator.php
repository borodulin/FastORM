<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\Command\ParamsAwareInterface;
use FastOrm\Command\ParamsAwareTrait;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;

class BetweenOperator implements
    OperatorInterface,
    ExpressionBuilderInterface,
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

    public function build(): string
    {
        $paramStart = $this->params->bindValue($this->intervalStart);
        $paramEnd = $this->params->bindValue($this->intervalEnd);
        $column = $this->compiler->quoteColumnName($this->column);
        return "$column BETWEEN :$paramStart AND :$paramEnd";
    }
}
