<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

interface OnClauseInterface
{
    public function on(string $condition): FromClauseInterface;
}
