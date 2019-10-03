<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

interface JoinAliasClauseInterface extends OnClauseInterface
{
    public function alias($alias): OnClauseInterface;
}
