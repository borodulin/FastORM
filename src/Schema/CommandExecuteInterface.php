<?php

declare(strict_types=1);

namespace FastOrm\Schema;


interface CommandExecuteInterface
{
    public function execute(array $params = []): bool;
}
