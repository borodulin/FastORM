<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\ExpressionInterface;
use FastOrm\SQL\SearchCondition\Compound;

class HavingClause extends Compound
{
    public function build(ExpressionInterface $expression): string
    {
        $having = parent::build($expression);

        return $having === '' ? '' : 'HAVING ' . $having;
    }
}
