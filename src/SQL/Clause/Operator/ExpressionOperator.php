<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Operator;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class ExpressionOperator implements
    OperatorInterface,
    CompilerAwareInterface,
    ExpressionBuilderInterface
{
    use CompilerAwareTrait;

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

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof ExpressionOperator) {
            throw new InvalidArgumentException();
        }
        $this->compiler->getParams()->bindAll($this->params);
        if ($expression->expression instanceof ExpressionInterface) {
            $expression->expression = $this->compiler->compile($expression->expression);
        }
        return $expression->expression;
    }
}
