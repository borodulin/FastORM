<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

use Borodulin\ORM\SQL\Clause\SelectClauseInterface;

interface SelectDistinctInterface extends SelectClauseInterface
{
    public function distinct(): SelectClauseInterface;
}
