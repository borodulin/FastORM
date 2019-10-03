<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

interface AliasClauseInterface
{
    public function alias($alias): FromClauseInterface;
}
