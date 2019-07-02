<?php

declare(strict_types=true);

namespace FastOrm\SQL\Operator;

use FastOrm\SQL\Expression\SearchExpressionInterface;
use FastOrm\SQL\QueryInterface;

interface CompoundInterface extends QueryInterface
{
    public function and(): SearchExpressionInterface;
    public function or(): SearchExpressionInterface;
}
