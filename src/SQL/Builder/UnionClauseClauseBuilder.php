<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Clause\UnionClause;

class UnionClauseClauseBuilder implements ClauseBuilderInterface
{

    /**
     * @var UnionClause
     */
    private $clause;

    public function __construct(UnionClause $clause)
    {
        $this->clause = $clause;
    }

    public function getSql(): string
    {
        return 'UNION';
    }
}
