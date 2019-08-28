<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Clause\FromClause;

class FromClauseClauseBuilder implements ClauseBuilderInterface
{
    /**
     * @var FromClause
     */
    private $clause;

    public function __construct(FromClause $clause)
    {
        $this->clause = $clause;
    }

    public function getSql(): string
    {
        return 'FROM';
    }
}
