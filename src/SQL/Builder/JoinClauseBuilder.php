<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Clause\JoinClause;

class JoinClauseBuilder implements BuilderInterface
{

    /**
     * @var JoinClause
     */
    private $clause;

    public function __construct(JoinClause $clause)
    {
        $this->clause = $clause;
    }

    public function build(): string
    {
        // TODO: Implement build() method.
    }
}
