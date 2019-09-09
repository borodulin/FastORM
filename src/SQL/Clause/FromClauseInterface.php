<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;

interface FromClauseInterface extends QueryInterface, AliasClauseInterface
{
    public function join($join, string $joinType = 'inner join'): JoinAliasClauseInterface;

    public function innerJoin($join): JoinAliasClauseInterface;

    public function leftJoin($join): JoinAliasClauseInterface;

    public function rightJoin($join): JoinAliasClauseInterface;

    public function fullJoin($join): JoinAliasClauseInterface;
}
