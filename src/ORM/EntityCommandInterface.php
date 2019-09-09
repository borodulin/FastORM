<?php

declare(strict_types=1);

namespace FastOrm\ORM;

use FastOrm\Command\CommandInterface;
use FastOrm\ORM\Fetch\FetchEntityInterface;

interface EntityCommandInterface extends CommandInterface
{
    public function fetch(array $params = []): FetchEntityInterface;
}
