<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition;

use FastOrm\SQL\Clause\SelectInterface;

interface CompoundInterface extends SelectInterface
{
    public function and(): ConditionInterface;
    public function or(): ConditionInterface;
}
