<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause;

use Borodulin\ORM\SQL\Clause\Insert\ColumnsClauseInterface;
use Borodulin\ORM\SQL\ExpressionInterface;

interface InsertClauseInterface extends ExpressionInterface, HasStatementInterface
{
    public function into($table): ColumnsClauseInterface;
}
