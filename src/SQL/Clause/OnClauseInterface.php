<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;

interface OnClauseInterface
{
    public function on(string $condition): QueryInterface;
}
