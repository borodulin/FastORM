<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;

interface SelectClauseInterface extends QueryInterface
{
    public function distinct(): QueryInterface;
}
