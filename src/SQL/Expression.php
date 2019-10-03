<?php

declare(strict_types=1);

namespace FastOrm\SQL;


class Expression implements
    ExpressionInterface,
    ParamsAwareInterface
{
    use ParamsAwareTrait;
    /**
     * @var string
     */
    private $expression;
    /**
     * @var array
     */
    private $bindParams;

    public function __construct(string $expression, array $params = [])
    {
        $this->expression = $expression;
        $this->bindParams = $params;
    }

    public function __toString(): string
    {
        $this->params->bindAll($this->bindParams);
        return $this->expression;
    }
}
