<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\Compound\ClauseContainer as CompoundClauseContainer;
use FastOrm\SQL\ExpressionInterface;

class WhereClause extends CompoundClauseContainer
{
    public function build(ExpressionInterface $expression): string
    {
        $where = parent::build($expression);

        return $where === '' ? '' : 'WHERE ' . $where;
    }
}
