<?php

declare(strict_types=1);

namespace FastOrm\SQL;

use FastOrm\Fetch\FetchInterface;

interface CommandInterface extends BindParamsInterface
{
    public function fetch(array $params = []): FetchInterface;

    public function execute(array $params = []): bool;
}
