<?php

declare(strict_types=1);

namespace FastOrm\PdoCommand\Fetch;

use FastOrm\PdoCommand\StatementInterface;

interface IteratorFactoryInterface
{
    public function create(StatementInterface $statement): CursorInterface;
}
