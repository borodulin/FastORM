<?php

declare(strict_types=1);

namespace Borodulin\ORM\SQL\Clause;

interface ExecuteInterface
{
    public function execute(array $params = []): int;
}
