<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Clause\SelectClause;

class SelectClauseBuilder implements BuilderInterface
{

    /**
     * @var SelectClause
     */
    private $clause;

    public function __construct(SelectClause $clause)
    {
        $this->clause = $clause;
    }

    public function build(): string
    {
        // TODO: Implement build() method.
    }
}
