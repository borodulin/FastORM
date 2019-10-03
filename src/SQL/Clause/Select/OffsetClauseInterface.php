<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\SelectInterface;

interface OffsetClauseInterface extends SelectInterface
{
    public function offset(int $offset): SelectInterface;
}
