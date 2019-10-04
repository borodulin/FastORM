<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\SelectInterface;

interface FromClauseInterface extends SelectInterface, AliasClauseInterface
{
    public function join($join, string $joinType = 'inner join'): JoinAliasClauseInterface;

    public function innerJoin($join): JoinAliasClauseInterface;

    public function leftJoin($join): JoinAliasClauseInterface;

    public function rightJoin($join): JoinAliasClauseInterface;

    public function fullJoin($join): JoinAliasClauseInterface;
}