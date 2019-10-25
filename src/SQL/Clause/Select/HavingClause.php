<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\Compound\Compound;
use FastOrm\SQL\ExpressionInterface;

class HavingClause extends Compound
{
    public function build(ExpressionInterface $expression): string
    {
        $having = parent::build($expression);

        return $having === '' ? '' : 'HAVING ' . $having;
    }
}
