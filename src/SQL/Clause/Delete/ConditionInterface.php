<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Delete;

use FastOrm\SQL\Clause\ExecuteInterface;
use FastOrm\SQL\ExpressionInterface;

interface ConditionInterface extends
    NotOperatorListInterface,
    ExpressionInterface,
    ExecuteInterface
{
}
