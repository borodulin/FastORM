<?php

declare(strict_types=1);

namespace FastOrm\Driver\Postgres;

use FastOrm\Driver\AbstractConnection;
use FastOrm\Driver\SavepointInterface;
use FastOrm\Driver\SavepointTrait;

class Connection extends AbstractConnection implements SavepointInterface
{
    use SavepointTrait;
}
