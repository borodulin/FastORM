<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\SelectInterface;

interface SelectClauseInterface extends SelectInterface
{
    public function distinct(): SelectInterface;
}
