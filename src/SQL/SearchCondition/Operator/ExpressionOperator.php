<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\Command\ParamsBinderAwareInterface;
use FastOrm\Command\ParamsBinderAwareTrait;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class ExpressionOperator implements
    OperatorInterface,
    ExpressionBuilderInterface,
    CompilerAwareInterface,
    ParamsBinderAwareInterface
{
    use CompilerAwareTrait, ParamsBinderAwareTrait;

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
        $this->paramsBinder->bindParams($this->params);
        if ($this->expression instanceof ExpressionInterface) {
            $this->expression = $this->compiler->compile($this->expression);
        }
        return $this->expression;
    }
}
