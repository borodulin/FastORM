<?php

declare(strict_types=1);

namespace FastOrm\Driver;

use FastOrm\Command\ParamsInterface;
use FastOrm\SQL\CompilerInterface;
use PDO;

interface DriverInterface
{
    public function createCompiler(ParamsInterface $params): CompilerInterface;

    public function createPdoInstance(
        string $dsn,
        string $username = null,
        string $passwd = null,
        array $options = []
    ): PDO;
}
