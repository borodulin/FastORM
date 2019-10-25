<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Insert;

use Countable;
use FastOrm\SQL\Clause\ExecuteInterface;

interface ColumnsClauseInterface extends ExecuteInterface, Countable
{
    public function columns(array $columns): ValuesClauseInterface;
}
