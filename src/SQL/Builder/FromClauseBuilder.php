<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Clause\FromClause;

class FromClauseBuilder implements BuilderInterface
{
    /**
     * @var FromClause
     */
    private $clause;

    public function __construct(FromClause $clause)
    {
        $this->clause = $clause;
    }

    public function build(): string
    {
        // TODO: Implement build() method.
    }
}
