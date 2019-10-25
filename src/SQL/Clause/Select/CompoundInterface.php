<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\SelectClauseInterface;

interface CompoundInterface extends SelectClauseInterface
{
    public function and(): ConditionInterface;
    public function or(): ConditionInterface;
}
