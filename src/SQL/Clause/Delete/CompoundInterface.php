<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Delete;

use Borodulin\ORM\SQL\Clause\ExecuteInterface;

interface CompoundInterface extends ExecuteInterface
{
    public function and(): ConditionInterface;

    public function or(): ConditionInterface;
}
