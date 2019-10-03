<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select\Builder;

use FastOrm\SQL\Clause\Select\WhereClause;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionInterface;

class WhereClauseBuilder implements ExpressionInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var WhereClause
     */
    private $clause;

    public function __construct(WhereClause $clause)
    {
        $this->clause = $clause;
    }

    public function __toString(): string
    {
        $where = $this->compiler->compile($this->clause->getCompound());

        return $where === '' ? '' : 'WHERE ' . $where;
    }
}
