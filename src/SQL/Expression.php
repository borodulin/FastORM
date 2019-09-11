<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\Command\ParamsAwareInterface;
use FastOrm\Command\ParamsAwareTrait;

class Expression implements
    ExpressionInterface,
    ExpressionBuilderInterface,
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

    public function build(): string
    {
        $this->params->bindAll($this->bindParams);
        return $this->expression;
    }
}
