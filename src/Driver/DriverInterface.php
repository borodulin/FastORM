<?php

declare(strict_types=1);

namespace FastOrm\Driver;

use FastOrm\SQL\BuilderFactoryInterface;
use PDO;

interface DriverInterface
{
    public function createBuilderFactory(): BuilderFactoryInterface;

    public function createPdoInstance(
        string $dsn,
        string $username = null,
        string $passwd = null,
        array $options = []
    ): PDO;
}
