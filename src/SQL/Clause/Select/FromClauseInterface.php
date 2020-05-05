<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

use Borodulin\ORM\SQL\Clause\SelectClauseInterface;

interface FromClauseInterface extends SelectClauseInterface, AliasClauseInterface
{
    public function join($join, string $joinType = 'inner join'): JoinAliasClauseInterface;

    public function innerJoin($join): JoinAliasClauseInterface;

    public function leftJoin($join): JoinAliasClauseInterface;

    public function rightJoin($join): JoinAliasClauseInterface;

    public function fullJoin($join): JoinAliasClauseInterface;
}
