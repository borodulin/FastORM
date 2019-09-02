<?php

declare(strict_types=1);

namespace FastOrm\Driver;

use FastOrm\SQL\BindParamsInterface;
use FastOrm\SQL\ExpressionBuilderInterface;
use PDO;

interface DriverInterface
{
    public function createExpressionBuilder(BindParamsInterface $bindParams): ExpressionBuilderInterface;

    public function createPdoInstance(
        string $dsn,
        string $username = null,
        string $passwd = null,
        array $options = []
    ): PDO;
}
