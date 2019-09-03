<?php

declare(strict_types=1);

namespace FastOrm\SQL;

class Expression implements
    ExpressionInterface,
    ExpressionBuilderInterface,
    ParamsBinderAwareInterface
{
    use ParamsBinderAwareTrait;
    /**
     * @var string
     */
    private $expression;
    /**
     * @var array
     */
    private $params;

    public function __construct(string $expression, array $params = [])
    {
        $this->expression = $expression;
        $this->params = $params;
    }

    public function build(): string
    {
        $this->paramsBinder->bindParams($this->params);
        return $this->expression;
    }
}
