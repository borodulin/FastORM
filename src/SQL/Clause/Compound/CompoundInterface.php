<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Compound;

interface CompoundInterface
{
    public function and(): ConditionInterface;

    public function or(): ConditionInterface;
}
