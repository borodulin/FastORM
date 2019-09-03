<?php


namespace FastOrm\SQL;


class Expression implements ExpressionInterface
{
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

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getExpression(): string
    {
        return $this->expression;
    }
}
