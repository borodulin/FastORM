<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause\Select;

interface JoinAliasClauseInterface extends OnClauseInterface
{
    public function alias($alias): OnClauseInterface;
}
