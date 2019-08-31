<?php

declare(strict_types=1);

namespace FastOrm\Driver;

use FastOrm\NotSupportedException;

class DriverFactory
{
    private static $driverMap = [
        'pgsql' => 'FastOrm\Driver\Postgres\Driver', // PostgreSQL
        'mysqli' => 'FastOrm\Driver\MySQL\Driver', // MySQL
        'mysql' => 'FastOrm\Driver\MySQL\Driver', // MySQL
        'sqlite' => 'FastOrm\Driver\Sqlite\Driver', // sqlite 3
        'sqlite2' => 'FastOrm\Driver\Sqlite\Driver', // sqlite 2
        'sqlsrv' => 'FastOrm\Driver\MSSQL\Driver', // newer MSSQL driver on MS Windows hosts
        'mssql' => 'FastOrm\Driver\MSSQL\Driver', // older MSSQL driver on MS Windows hosts
        'dblib' => 'FastOrm\Driver\MSSQL\Driver', // dblib drivers on GNU/Linux (and maybe other OSes) hosts
        'oci' => 'FastOrm\Driver\Oracle\Driver', // Oracle driver
        'cubrid' => 'FastOrm\Driver\CUBRID\Driver', // CUBRID
    ];

    /**
     * @param $dsn
     * @return DriverInterface
     * @throws NotSupportedException
     */
    public function __invoke($dsn): DriverInterface
    {
        $driver = explode(':', $dsn)[0];
        if (!$classname = static::$driverMap[$driver] ?? null) {
            throw new NotSupportedException();
        }
        /** @var DriverInterface $instance */
        return new $classname();
    }
}
