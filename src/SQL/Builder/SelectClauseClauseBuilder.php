<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Clause\SelectClause;

class SelectClauseClauseBuilder implements ClauseBuilderInterface
{

    /**
     * @var SelectClause
     */
    private $clause;

    public function __construct(SelectClause $clause)
    {
        $this->clause = $clause;
    }

    public function getSql(): string
    {
        return 'SELECT *';
    }
}
