<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Delete;

use Borodulin\ORM\SQL\Clause\ExecuteInterface;

interface WhereClauseInterface extends ExecuteInterface
{
    public function where(): ConditionInterface;
}
