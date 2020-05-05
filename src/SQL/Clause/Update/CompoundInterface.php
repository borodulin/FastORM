<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Update;

use Borodulin\ORM\SQL\Clause\ExecuteInterface;
use Countable;

interface CompoundInterface extends ExecuteInterface, Countable
{
    public function and(): ConditionInterface;

    public function or(): ConditionInterface;
}
