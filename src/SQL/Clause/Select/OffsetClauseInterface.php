<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

use Borodulin\ORM\SQL\Clause\SelectClauseInterface;

interface OffsetClauseInterface extends SelectClauseInterface
{
    public function offset(int $offset): SelectClauseInterface;
}
