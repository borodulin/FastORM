<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

use FastOrm\SQL\Clause\JoinClause;

class JoinClauseClauseBuilder implements ClauseBuilderInterface
{

    /**
     * @var JoinClause
     */
    private $clause;

    public function __construct(JoinClause $clause)
    {
        $this->clause = $clause;
    }

    public function getSql(): string
    {
        return 'JOIN';
    }
}
