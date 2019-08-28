<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Clause\OrderByClause;

class OrderByClauseClauseBuilder implements ClauseBuilderInterface
{
    /**
     * @var OrderByClause
     */
    private $clause;

    public function __construct(OrderByClause $clause)
    {
        $this->clause = $clause;
    }

    public function getSql(): string
    {
        return 'ORDER BY';
    }
}
