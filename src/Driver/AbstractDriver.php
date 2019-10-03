<?php

declare(strict_types=1);

namespace FastOrm\Driver;

use FastOrm\EventDispatcherAwareTrait;
use FastOrm\SQL\Compiler;
use FastOrm\SQL\CompilerInterface;
use FastOrm\SQL\ParamsInterface;
use PDO;
use Psr\Log\LoggerAwareTrait;

abstract class AbstractDriver implements DriverInterface
{
    use LoggerAwareTrait, EventDispatcherAwareTrait;

    public function createCompiler(ParamsInterface $params): CompilerInterface
    {
        $compiler = new Compiler($params);
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
}
