<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Delete;

use Borodulin\ORM\SQL\Clause\ExecuteInterface;
use Borodulin\ORM\SQL\ExpressionInterface;

interface ConditionInterface extends
    NotOperatorListInterface,
    ExpressionInterface,
    ExecuteInterface
{
}
