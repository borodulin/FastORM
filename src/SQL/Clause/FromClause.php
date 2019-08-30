<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;
use SplStack;

class FromClause extends AbstractClause
{
    private $from;

    public function __construct(QueryInterface $query)
    {
        parent::__construct($query);
        $this->from = new SplStack();
    }

    public function addFrom($from): void
    {
        $alias = new AliasClause($this->getQuery());
        $alias->setExpression($from);
        $this->from->push($alias);
    }

    public function setAlias($alias): void
    {
        /** @var AliasClause $alias */
        $aliasClause = $this->from->top();
        $aliasClause->setAlias($alias);
    }

    /**
     * @return SplStack
     */
    public function getFrom(): SplStack
    {
        return $this->from;
    }
}
