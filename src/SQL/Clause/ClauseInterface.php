<?php

declare(strict_types=true);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;

interface ClauseInterface
{
    public function getQuery(): QueryInterface;
}
