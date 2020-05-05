<?php

declare(strict_types=1);

namespace Borodulin\ORM\Driver;

use Borodulin\ORM\NotSupportedException;

class DriverFactory
{
    private static $driverMap = [
        'pgsql' => 'Borodulin\ORM\Driver\Postgres\Driver', // PostgreSQL
        'mysqli' => 'Borodulin\ORM\Driver\MySQL\Driver', // MySQL
        'mysql' => 'Borodulin\ORM\Driver\MySQL\Driver', // MySQL
        'sqlite' => 'Borodulin\ORM\Driver\Sqlite\Driver', // sqlite 3
        'sqlite2' => 'Borodulin\ORM\Driver\Sqlite\Driver', // sqlite 2
        'sqlsrv' => 'Borodulin\ORM\Driver\MSSQL\Driver', // newer MSSQL driver on MS Windows hosts
        'mssql' => 'Borodulin\ORM\Driver\MSSQL\Driver', // older MSSQL driver on MS Windows hosts
        'dblib' => 'Borodulin\ORM\Driver\MSSQL\Driver', // dblib drivers on GNU/Linux (and maybe other OSes) hosts
        'oci' => 'Borodulin\ORM\Driver\Oracle\Driver', // Oracle driver
        'cubrid' => 'Borodulin\ORM\Driver\CUBRID\Driver', // CUBRID
    ];

    /**
     * @param $dsn
     *
     * @throws NotSupportedException
     */
    public function __invoke($dsn): DriverInterface
    {
        $driver = explode(':', $dsn)[0];
        if (!$classname = static::$driverMap[$driver] ?? null) {
            throw new NotSupportedException();
        }
        /* @var DriverInterface $instance */
        return new $classname();
    }
}
