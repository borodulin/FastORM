<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ContextInterface;
use FastOrm\SQL\ExpressionBuilderInterface;
use FastOrm\SQL\ExpressionInterface;

class ExpressionOperator extends AbstractOperator implements
    CompilerAwareInterface,
    ExpressionBuilderInterface
{
    use CompilerAwareTrait;

    private $expression;
    /**
     * @var array
     */
    private $bindParams;

    public function __construct($expression, array $params, ContextInterface $context)
    {
        $this->expression = $expression;
        $this->bindParams = $params;
        parent::__construct($context);
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
        $this->compiler->getContext()->getParams()->bindAll($this->bindParams);
        if ($expression->expression instanceof ExpressionInterface) {
            $expression->expression = $this->compiler->compile($expression->expression);
        }
        return $expression->expression;
    }
}
