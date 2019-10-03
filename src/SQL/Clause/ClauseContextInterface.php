<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\ContextInterface;
use FastOrm\SQL\ExpressionInterface;

interface ClauseContextInterface extends ExpressionInterface, ContextInterface
{
}
