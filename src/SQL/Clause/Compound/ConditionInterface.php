<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Compound;

use FastOrm\SQL\ExpressionInterface;

interface ConditionInterface extends NotOperatorListInterface, ExpressionInterface
{
}
