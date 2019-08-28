<?php

declare(strict_types=1);

namespace FastOrm\Driver;

use FastOrm\Fetch\FetchInterface;

interface CommandFetchInterface
{
    public function fetch(array $params = []): FetchInterface;
}
