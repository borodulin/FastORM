<?php

declare(strict_types=true);

namespace FastOrm\SQL\Operator;

class ExpressionOperator implements OperatorInterface
{
    private $expression;
    /**
     * @var array
     */
    private $params;

    public function __construct($expression, array $params)
    {
        $this->expression = $expression;
        $this->params = $params;
    }
}
