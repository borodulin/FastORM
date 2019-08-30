<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\SQL\Clause\UnionClause;
use FastOrm\SQL\Clause\UnionItem;

class UnionClauseBuilder extends AbstractClauseBuilder
{

    /**
     * @var UnionClause
     */
    private $clause;

    public function __construct(UnionClause $clause)
    {
        $this->clause = $clause;
    }

    public function getText(): string
    {
        $unions = $this->clause->getUnions();
        if (empty($unions)) {
            return '';
        }

        $result = '';

        /** @var UnionItem $union */
        foreach ($unions as $union) {
            $query = $this->buildExpression($union->getQuery());
            $result .= 'UNION ' . ($union->isAll() ? 'ALL ' : '') . '( ' . $query . ' ) ';
        }

        return trim($result);
    }
}
