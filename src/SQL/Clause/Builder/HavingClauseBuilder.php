<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Builder;

use FastOrm\SQL\Clause\HavingClause;
use FastOrm\SQL\CompilerAwareInterface;
use FastOrm\SQL\CompilerAwareTrait;
use FastOrm\SQL\ExpressionBuilderInterface;

class HavingClauseBuilder implements ExpressionBuilderInterface, CompilerAwareInterface
{
    use CompilerAwareTrait;

    /**
     * @var HavingClause
     */
    private $clause;

    public function __construct(HavingClause $clause)
    {
        $this->clause = $clause;
    }

    public function build(): string
    {
        $having = $this->compiler->compile($this->clause->getCompound());

        return $having === '' ? '' : 'HAVING ' . $having;
    }
}
