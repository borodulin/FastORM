<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;

interface AliasClauseInterface extends QueryInterface
{
    public function alias($alias): QueryInterface;
}
