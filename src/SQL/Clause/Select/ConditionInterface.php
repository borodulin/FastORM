<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\ExpressionInterface;

interface ConditionInterface extends ExpressionInterface, NotOperatorListInterface
{
}
