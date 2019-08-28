<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;

interface ClauseInterface
{
    public function getQuery(): QueryInterface;
}
