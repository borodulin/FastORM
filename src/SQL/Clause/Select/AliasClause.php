<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

use Borodulin\ORM\SQL\ExpressionInterface;

class AliasClause implements ExpressionInterface
{
    private $expression;

    private $alias;

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

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }
}
