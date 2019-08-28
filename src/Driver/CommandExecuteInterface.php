<?php

declare(strict_types=1);

namespace FastOrm\Driver;


interface CommandExecuteInterface
{
    public function execute(array $params = []): bool;
}
