<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;


interface JoinAliasClauseInterface extends OnClauseInterface
{
    public function alias($alias): OnClauseInterface;
}
