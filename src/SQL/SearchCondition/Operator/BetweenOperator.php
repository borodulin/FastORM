<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ContextInterface;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class BetweenOperator extends AbstractOperator implements
    ExpressionBuilderInterface,
    CompilerAwareInterface
{
    use CompilerAwareTrait;

    private $column;
    private $intervalStart;
    private $intervalEnd;

    public function __construct($column, $intervalStart, $intervalEnd, ContextInterface $context)
    {
        $this->column = $column;
        $this->intervalStart = $intervalStart;
        $this->intervalEnd = $intervalEnd;
        parent::__construct($context);
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof BetweenOperator) {
            throw new InvalidArgumentException();
        }
        $params = $this->compiler->getContext()->getParams();
        $paramStart = $params->bindValue($expression->intervalStart);
        $paramEnd = $params->bindValue($expression->intervalEnd);
        $column = $this->compiler->quoteColumnName($expression->column);
        return "$column BETWEEN :$paramStart AND :$paramEnd";
    }
}
