<?php

declare(strict_types=true);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;

interface OffsetClauseInterface extends QueryInterface
{
    public function offset(int $offset): QueryInterface;
}
