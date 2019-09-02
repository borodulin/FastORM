<?php

declare(strict_types=1);

namespace FastOrm\Driver;

use FastOrm\SQL\BindParamsInterface;
use FastOrm\SQL\ExpressionBuilder;
use FastOrm\SQL\ExpressionBuilderInterface;
use PDO;

class AbstractDriver implements DriverInterface
{
    public function createExpressionBuilder(BindParamsInterface $bindParams): ExpressionBuilderInterface
    {
        return new ExpressionBuilder($bindParams);
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
