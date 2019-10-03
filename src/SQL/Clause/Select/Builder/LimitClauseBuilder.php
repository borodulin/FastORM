<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select\Builder;

use FastOrm\SQL\Clause\Select\LimitClause;
use FastOrm\SQL\ExpressionInterface;

class LimitClauseBuilder implements ExpressionInterface
{

    /**
     * @var LimitClause
     */
    private $clause;

    public function __construct(LimitClause $clause)
    {
        $this->clause = $clause;
    }

    public function __toString(): string
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
