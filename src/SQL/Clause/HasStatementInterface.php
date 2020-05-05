<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause;

use Borodulin\ORM\PdoCommand\StatementInterface;

interface HasStatementInterface
{
    public function statement(array $options = []): StatementInterface;
}
