<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\SQL\Clause\UnionClause;
use FastOrm\SQL\Clause\UnionItem;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;

class UnionClauseBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var UnionClause
     */
    private $clause;

    public function __construct(UnionClause $clause)
    {
        $this->clause = $clause;
    }

    public function build(): string
    {
        $unions = $this->clause->getUnions();
        if (empty($unions)) {
            return '';
        }

        $result = '';

        /** @var UnionItem $union */
        foreach ($unions as $union) {
            $query = $this->compiler->compile($union->getQuery());
            $result .= ' UNION ' . ($union->isAll() ? 'ALL ' : '') . $query;
        }

        return trim($result);
    }
}
