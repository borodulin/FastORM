<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Clause\GroupByClause;

class GroupByClauseBuilder implements BuilderInterface
{

    /**
     * @var GroupByClause
     */
    private $clause;

    public function __construct(GroupByClause $clause)
    {
        $this->clause = $clause;
    }

    public function build(): string
    {
        // TODO: Implement build() method.
    }
}
