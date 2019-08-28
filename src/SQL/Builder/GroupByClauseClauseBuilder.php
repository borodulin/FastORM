<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Clause\GroupByClause;

class GroupByClauseClauseBuilder implements ClauseBuilderInterface
{

    /**
     * @var GroupByClause
     */
    private $clause;

    public function __construct(GroupByClause $clause)
    {
        $this->clause = $clause;
    }

    public function getSql(): string
    {
        return 'GROUP BY';
    }
}
