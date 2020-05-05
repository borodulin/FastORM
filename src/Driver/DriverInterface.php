<?php

declare(strict_types=1);

namespace Borodulin\ORM\Driver;

use Borodulin\ORM\EventDispatcherAwareInterface;
use Borodulin\ORM\SQL\CompilerInterface;
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

    /**
     * Sets transaction isolation level of the db connection.
     */
    public function setTransactionIsolationLevel(PDO $pdo, string $isolationLevel);
}
