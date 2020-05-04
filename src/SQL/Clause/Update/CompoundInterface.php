<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Update;

use Countable;
use FastOrm\SQL\Clause\ExecuteInterface;

interface CompoundInterface extends ExecuteInterface, Countable
{
    public function and(): ConditionInterface;

    public function or(): ConditionInterface;
}
