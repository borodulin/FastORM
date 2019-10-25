<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

interface ExecuteInterface
{
    public function execute(array $params = []): int;
}
