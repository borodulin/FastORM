<?php

declare(strict_types=1);

namespace FastOrm\Driver\Postgres;

use FastOrm\Driver\AbstractDriver;
use FastOrm\Driver\SavepointInterface;
use FastOrm\Driver\SavepointTrait;

class Driver extends AbstractDriver implements SavepointInterface
{
    use SavepointTrait;
}
