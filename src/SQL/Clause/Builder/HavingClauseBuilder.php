<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\SQL\Clause\HavingClause;

class HavingClauseBuilder extends AbstractClauseBuilder
{
    /**
     * @var HavingClause
     */
    private $clause;

    public function __construct(HavingClause $clause)
    {
        $this->clause = $clause;
    }

    public function getText(): string
    {
        $having = $this->buildExpression($this->clause->getCompound());

        return $having === '' ? '' : 'HAVING ' . $having;
    }
}
