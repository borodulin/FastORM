<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select\Builder;

use FastOrm\SQL\Clause\Select\HavingClause;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionInterface;

class HavingClauseBuilder implements ExpressionInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var HavingClause
     */
    private $clause;

    public function __construct(HavingClause $clause)
    {
        $this->clause = $clause;
    }

    public function __toString(): string
    {
        $having = $this->compiler->compile($this->clause->getCompound());

        return $having === '' ? '' : 'HAVING ' . $having;
    }
}
