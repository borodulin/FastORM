<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Compound;

use Borodulin\ORM\SQL\ExpressionInterface;

interface ConditionInterface extends NotOperatorListInterface, ExpressionInterface
{
}
