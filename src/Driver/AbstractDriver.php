<?php

declare(strict_types=1);

namespace Borodulin\ORM\Driver;

use Borodulin\ORM\EventDispatcherAwareTrait;
use Borodulin\ORM\SQL\Compiler;
use Borodulin\ORM\SQL\CompilerInterface;
use PDO;
use Psr\Log\LoggerAwareTrait;

abstract class AbstractDriver implements DriverInterface
{
    use LoggerAwareTrait;
    use EventDispatcherAwareTrait;

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

    public function setTransactionIsolationLevel(PDO $pdo, string $isolationLevel): void
    {
        $pdo->exec("SET TRANSACTION ISOLATION LEVEL $isolationLevel");
    }
}
