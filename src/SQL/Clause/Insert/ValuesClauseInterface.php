<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Insert;

use Countable;
use FastOrm\SQL\Clause\ExecuteInterface;

interface ValuesClauseInterface extends ExecuteInterface, Countable
{
    public function values($values): self;
}
