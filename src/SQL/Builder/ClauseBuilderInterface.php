<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

interface ClauseBuilderInterface
{
    public function getSql(): string;
}
