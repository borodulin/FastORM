<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

interface AliasClauseInterface
{
    public function as($alias): FromClauseInterface;
}
