<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Clause\UnionClause;

class UnionClauseBuilder implements BuilderInterface
{

    /**
     * @var UnionClause
     */
    private $clause;

    public function __construct(UnionClause $clause)
    {
        $this->clause = $clause;
    }

    public function build(): string
    {
        // TODO: Implement build() method.
    }
}
