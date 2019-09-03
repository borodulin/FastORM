<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\SQL\Clause\WhereClause;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;

class WhereClauseBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var WhereClause
     */
    private $clause;

    public function __construct(WhereClause $clause)
    {
        $this->clause = $clause;
    }

    public function build(): string
    {
        $where = $this->compiler->compile($this->clause->getCompound());

        return $where === '' ? '' : 'WHERE ' . $where;
    }
}
