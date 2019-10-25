<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\Compound\Compound;
use FastOrm\SQL\ExpressionInterface;

class WhereClause extends Compound
{
    public function build(ExpressionInterface $expression): string
    {
        $where = parent::build($expression);

        return $where === '' ? '' : 'WHERE ' . $where;
    }
}
