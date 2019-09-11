<?php

declare(strict_types=1);

namespace FastOrm\ORM;

use FastOrm\Command\CommandInterface;
use FastOrm\ConnectionInterface;
use FastOrm\SQL\QueryInterface;

interface EntityQueryInterface extends QueryInterface
{
    public function prepare(ConnectionInterface $connection): CommandInterface;
}
