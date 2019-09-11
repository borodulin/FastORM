<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\Query;
use SplStack;

class FromClause extends AbstractClause implements FromClauseInterface
{
    private $from;
    /**
     * @var JoinClause
     */
    private $joinClause;

    public function __construct(Query $query)
    {
        parent::__construct($query);
        $this->from = new SplStack();
        $this->joinClause = new JoinClause($query);
        $this->joinClause->setFromClause($this);
    }

    public function addFrom($from): FromClause
    {
        $alias = new AliasClause($this->query);
        $alias->setExpression($from);
        $this->from->push($alias);
        return $this;
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

    public function alias($alias): FromClauseInterface
    {
        $this->setAlias($alias);
        return $this;
    }

    public function join($join, string $joinType = 'inner join'): JoinAliasClauseInterface
    {
        return $this->joinClause->addJoin($join, $joinType);
    }

    public function innerJoin($join): JoinAliasClauseInterface
    {
        return $this->joinClause->addJoin($join, 'inner join');
    }

    public function leftJoin($join): JoinAliasClauseInterface
    {
        return $this->joinClause->addJoin($join, 'left join');
    }

    public function rightJoin($join): JoinAliasClauseInterface
    {
        return $this->joinClause->addJoin($join, 'right join');
    }

    public function fullJoin($join): JoinAliasClauseInterface
    {
        return $this->joinClause->addJoin($join, 'full join');
    }

    /**
     * @return JoinClause
     */
    public function getJoinClause(): JoinClause
    {
        return $this->joinClause;
    }
}
