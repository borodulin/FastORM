<?php

declare(strict_types=1);

namespace FastOrm\SQL;

class Expression implements ExpressionInterface
{
    /**
     * @var string
     */
    protected $expression;
    /**
     * @var array
     */
    protected $params;

    public function __construct(string $expression, array $params = [])
    {
        $this->expression = $expression;
        $this->params = $params;
    }
}
