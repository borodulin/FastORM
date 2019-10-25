<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Update;

use FastOrm\SQL\Clause\ExecuteInterface;

interface CompoundInterface extends ExecuteInterface
{
    public function and(): ConditionInterface;
    public function or(): ConditionInterface;
}
