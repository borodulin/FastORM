<?php

declare(strict_types=1);

namespace FastOrm\Driver;

use FastOrm\EventDispatcherAwareInterface;
use FastOrm\SQL\CompilerInterface;
use PDO;
use Psr\Log\LoggerAwareInterface;

interface DriverInterface extends LoggerAwareInterface, EventDispatcherAwareInterface
{
    public function createCompiler(): CompilerInterface;

    public function createPdoInstance(
        string $dsn,
        string $username = null,
        string $passwd = null,
        array $options = []
    ): PDO;
}
