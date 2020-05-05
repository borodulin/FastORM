<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

use Borodulin\ORM\SQL\Clause\Compound\ClauseContainer as CompoundClauseContainer;
use Borodulin\ORM\SQL\ExpressionInterface;

class WhereClause extends CompoundClauseContainer
{
    public function build(ExpressionInterface $expression): string
    {
        $where = parent::build($expression);

        return '' === $where ? '' : trim('WHERE'.$where);
    }
}
