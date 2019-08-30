<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\SQL\Clause\LimitClause;

class LimitClauseBuilder extends AbstractClauseBuilder
{

    /**
     * @var LimitClause
     */
    private $clause;

    public function __construct(LimitClause $clause)
    {
        $this->clause = $clause;
    }

    public function getText(): string
    {
        $sql = '';
        if ($limit = $this->clause->getLimit()) {
            $sql = 'LIMIT ' . $limit;
        }
        if ($offset = $this->clause->getOffset()) {
            $sql .= ' OFFSET ' . $offset;
        }
        return $sql;
    }
}
