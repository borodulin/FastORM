<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\Compound\ClauseContainer as CompoundClauseContainer;
use FastOrm\SQL\ExpressionInterface;

class HavingClause extends CompoundClauseContainer
{
    public function build(ExpressionInterface $expression): string
    {
        $having = parent::build($expression);

        return $having === '' ? '' : trim('HAVING' . $having);
    }
}
