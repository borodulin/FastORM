<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause;

use Borodulin\ORM\SQL\Clause\Update\ConditionInterface;
use Borodulin\ORM\SQL\ExpressionInterface;
use Countable;

interface UpdateClauseInterface extends
    ExpressionInterface,
    ExecuteInterface,
    HasStatementInterface,
    Countable
{
    public function update($table): self;

    public function set(array $set): self;

    public function where(): ConditionInterface;
}
