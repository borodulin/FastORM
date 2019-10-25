<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Insert;

interface ValuesClauseInterface
{
    public function values($values): self;
}
