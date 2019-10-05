<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition;

use FastOrm\SQL\Clause\SelectClauseInterface;

interface CompoundInterface extends SelectClauseInterface
{
    public function and(): ConditionInterface;
    public function or(): ConditionInterface;
}
