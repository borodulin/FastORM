<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

use Borodulin\ORM\SQL\Clause\Compound\ClauseContainer as CompoundClauseContainer;
use Borodulin\ORM\SQL\ExpressionInterface;

class HavingClause extends CompoundClauseContainer
{
    public function build(ExpressionInterface $expression): string
    {
        $having = parent::build($expression);

        return '' === $having ? '' : trim('HAVING'.$having);
    }
}
