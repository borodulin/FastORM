<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Clause\OrderByClause;

class OrderByClauseBuilder implements BuilderInterface
{
    /**
     * @var OrderByClause
     */
    private $clause;

    public function __construct(OrderByClause $clause)
    {
        $this->clause = $clause;
    }

    public function build(): string
    {
        // TODO: Implement build() method.
    }
}
