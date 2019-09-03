<?php

declare(strict_types=1);

namespace FastOrm\Driver;

use FastOrm\Command\ParamsBinderInterface;
use FastOrm\SQL\Compiler;
use FastOrm\SQL\CompilerInterface;
use PDO;

class AbstractDriver implements DriverInterface
{
    public function createCompiler(ParamsBinderInterface $bindParams): CompilerInterface
    {
        return new Compiler($bindParams);
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
