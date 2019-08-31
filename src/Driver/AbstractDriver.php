<?php

declare(strict_types=1);

namespace FastOrm\Driver;

use FastOrm\SQL\BuilderFactory;
use FastOrm\SQL\BuilderFactoryInterface;
use PDO;

class AbstractDriver implements DriverInterface
{
    public function createBuilderFactory(): BuilderFactoryInterface
    {
        return new BuilderFactory($this);
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
