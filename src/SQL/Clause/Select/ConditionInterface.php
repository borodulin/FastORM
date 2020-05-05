<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

use Borodulin\ORM\SQL\ExpressionInterface;

interface ConditionInterface extends ExpressionInterface, NotOperatorListInterface
{
}
