<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition;

use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\SearchCondition\Operator\NotOperatorListInterface;

interface SearchConditionInterface extends NotOperatorListInterface, ExpressionInterface
{
}
