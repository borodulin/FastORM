<?php

declare(strict_types=1);

namespace FastOrm\Driver;

use FastOrm\SQL\BindParamsInterface;
use FastOrm\SQL\CompilerInterface;
use PDO;

interface DriverInterface
{
    public function createCompiler(BindParamsInterface $bindParams): CompilerInterface;

    public function createPdoInstance(
        string $dsn,
        string $username = null,
        string $passwd = null,
        array $options = []
    ): PDO;
}
