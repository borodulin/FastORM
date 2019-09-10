<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition;

use FastOrm\SQL\QueryInterface;

interface CompoundInterface extends QueryInterface
{
    public function and(): ConditionInterface;
    public function or(): ConditionInterface;
}
