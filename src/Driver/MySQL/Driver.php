<?php

declare(strict_types=1);

namespace Borodulin\ORM\Driver\MySQL;

use Borodulin\ORM\Driver\AbstractDriver;
use Borodulin\ORM\Driver\SavepointInterface;
use Borodulin\ORM\Driver\SavepointTrait;

class Driver extends AbstractDriver implements SavepointInterface
{
    use SavepointTrait;
}
