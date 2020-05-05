<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Insert;

use Borodulin\ORM\SQL\Clause\ExecuteInterface;
use Countable;

interface ColumnsClauseInterface extends ExecuteInterface, Countable
{
    public function columns(array $columns): ValuesClauseInterface;
}
