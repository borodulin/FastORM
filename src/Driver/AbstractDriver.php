<?php

declare(strict_types=1);

namespace FastOrm\Driver;

use FastOrm\EventDispatcherAwareTrait;
use FastOrm\SQL\Compiler;
use FastOrm\SQL\CompilerInterface;
use PDO;
use Psr\Log\LoggerAwareTrait;

abstract class AbstractDriver implements DriverInterface
{
    use LoggerAwareTrait, EventDispatcherAwareTrait;

    public function createCompiler(): CompilerInterface
    {
        $compiler = new Compiler();
        $this->logger && $compiler->setLogger($this->logger);
        $this->eventDispatcher && $compiler->setEventDispatcher($this->eventDispatcher);
        return $compiler;
    }

    public function createPdoInstance(
        string $dsn,
        string $username = null,
        string $passwd = null,
        array $options = []
    ): PDO {
        return new PDO($dsn, $username, $passwd, $options);
    }

    /**
     * @param PDO $pdo
     * @param string $isolationLevel
     */
    public function setTransactionIsolationLevel(PDO $pdo, string $isolationLevel)
    {
        $pdo->exec("SET TRANSACTION ISOLATION LEVEL $isolationLevel");
    }
}
