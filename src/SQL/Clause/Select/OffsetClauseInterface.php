<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\SelectClauseInterface;

interface OffsetClauseInterface extends SelectClauseInterface
{
    public function offset(int $offset): SelectClauseInterface;
}
