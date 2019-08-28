<?php

declare(strict_types=1);

namespace FastOrm\SQL\Builder;

interface BuilderInterface
{
    public function build(): string;
}
