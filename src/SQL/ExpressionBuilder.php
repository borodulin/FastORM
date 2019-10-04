<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\InvalidArgumentException;

class ExpressionBuilder extends Expression implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    public function __construct()
    {
        parent::__construct('');
    }

    public function build(ExpressionInterface $expression): string
    {
        if (!$expression instanceof Expression) {
            throw new InvalidArgumentException();
        }
        $this->compiler->getParams()->bindAll($expression->params);
        return $expression->expression;
    }
}
