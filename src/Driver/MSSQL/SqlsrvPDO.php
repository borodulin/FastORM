<?php

declare(strict_types=1);

namespace Borodulin\ORM\Driver\MSSQL;

use PDO;

class SqlsrvPDO extends PDO
{
    public function lastInsertId($name = null)
    {
        return $name ? parent::lastInsertId($name) : parent::lastInsertId();
    }
}
