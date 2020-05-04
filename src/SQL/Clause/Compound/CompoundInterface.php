<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Compound;

interface CompoundInterface
{
    public function and(): ConditionInterface;

    public function or(): ConditionInterface;
}
