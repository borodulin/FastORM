<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\Command\ParamsAwareInterface;
use FastOrm\Command\ParamsAwareTrait;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class ExpressionOperator implements
    OperatorInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface,
    ParamsAwareInterface
{
    use CompilerAwareTrait, ParamsAwareTrait;

    private $expression;
    /**
     * @var array
     */
    private $bindParams;

    public function __construct($expression, array $params = [])
    {
        $this->expression = $expression;
        $this->bindParams = $params;
    }

    public function build(): string
    {
        $this->params->bindAll($this->bindParams);
        if ($this->expression instanceof ExpressionInterface) {
            $this->expression = $this->compiler->compile($this->expression);
        }
        return $this->expression;
    }

    /**
     * @return mixed
     */
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     * @param mixed $expression
     */
    public function setExpression($expression): void
    {
        $this->expression = $expression;
    }
}
