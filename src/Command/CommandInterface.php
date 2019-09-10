<?php

declare(strict_types=1);

namespace FastOrm\Command;


use FastOrm\Command\Fetch\CursorInterface;
use FastOrm\Command\Fetch\FetchInterface;

interface CommandInterface extends ParamsBinderInterface
{
    public function fetch(array $params = []): FetchInterface;

    public function execute(array $params = []): bool;

    public function cursor(array $params = []): CursorInterface;
}
