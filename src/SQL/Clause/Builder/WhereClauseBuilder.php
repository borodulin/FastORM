<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\SQL\Clause\WhereClause;
use FastOrm\SQL\SearchCondition\Compound;

class WhereClauseBuilder extends AbstractClauseBuilder
{
    /**
     * @var WhereClause
     */
    private $clause;

    public function __construct(WhereClause $clause)
    {
        $this->clause = $clause;
    }

    public function getText(): string
    {
        $where = $this->buildExpression($this->clause->getCompound());

        return $where === '' ? '' : 'WHERE ' . $where;
    }

}
