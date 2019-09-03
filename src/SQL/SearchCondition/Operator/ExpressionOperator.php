<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\BindParamsAwareInterface;
use FastOrm\SQL\BindParamsAwareTrait;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class ExpressionOperator implements
    OperatorInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface,
    BindParamsAwareInterface
{
    use CompilerAwareTrait, BindParamsAwareTrait;

    private $expression;
    /**
     * @var array
     */
    private $params;

    public function __construct($expression, array $params = [])
    {
        $this->expression = $expression;
        $this->params = $params;
    }

    public function build(): string
    {
        $this->bindParams->bindParams($this->params);
        if ($this->expression instanceof ExpressionInterface) {
            $this->expression = $this->compiler->compile($this->expression);
        }
        return $this->expression;
    }
}
