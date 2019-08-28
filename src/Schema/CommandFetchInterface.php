<?php

declare(strict_types=1);

namespace FastOrm\Schema;

use FastOrm\Fetch\FetchInterface;

interface CommandFetchInterface
{
    public function fetch(array $params = []): FetchInterface;
}
