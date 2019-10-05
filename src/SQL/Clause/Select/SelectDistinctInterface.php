<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\SelectClauseInterface;

interface SelectDistinctInterface extends SelectClauseInterface
{
    public function distinct(): SelectClauseInterface;
}
