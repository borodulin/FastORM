<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

use Borodulin\ORM\SQL\Clause\SelectClauseInterface;

interface CompoundInterface extends SelectClauseInterface
{
    public function and(): ConditionInterface;

    public function or(): ConditionInterface;
}
