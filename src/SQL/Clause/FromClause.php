<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;
use SplStack;

class FromClause implements ClauseInterface
{
    private $query;

    private $from;

    public function __construct(QueryInterface $query)
    {
        $this->query = $query;
        $this->from = new SplStack();
    }

    public function getQuery(): QueryInterface
    {
        return $this->query;
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
        $aliasClause = $this->from->current();
        $aliasClause->setAlias($alias);
    }
}
