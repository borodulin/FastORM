<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause;

use Borodulin\ORM\SQL\Clause\Delete\WhereClauseInterface;
use Borodulin\ORM\SQL\ExpressionInterface;
use Countable;

interface DeleteClauseInterface extends
    ExpressionInterface,
    Countable,
    HasStatementInterface
{
    public function from($table): WhereClauseInterface;
}
