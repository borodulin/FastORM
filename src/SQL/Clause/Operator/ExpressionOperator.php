<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Operator;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\CompilerAwareInterface;
use Borodulin\ORM\SQL\CompilerAwareTrait;
use Borodulin\ORM\SQL\ExpressionBuilderInterface;
use Borodulin\ORM\SQL\ExpressionInterface;

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
        if (!$expression instanceof self) {
            throw new InvalidArgumentException();
        }
        $this->compiler->getParams()->bindAll($this->params);
        if ($expression->expression instanceof ExpressionInterface) {
            $expression->expression = $this->compiler->compile($expression->expression);
        }

        return $expression->expression;
    }
}
