<?php

declare(strict_types=1);

namespace FastOrm;

use FastOrm\Driver\AbstractConnection;

class ConnectionFactory
{
    private static $driverMap = [
        'pgsql' => 'FastOrm\Driver\Postgres\Connection', // PostgreSQL
        'mysqli' => 'FastOrm\Driver\MySQL\Connection', // MySQL
        'mysql' => 'FastOrm\Driver\MySQL\Connection', // MySQL
        'sqlite' => 'FastOrm\Driver\Sqlite\Connection', // sqlite 3
        'sqlite2' => 'FastOrm\Driver\Sqlite\Connection', // sqlite 2
        'sqlsrv' => 'FastOrm\Driver\MSSQL\Connection', // newer MSSQL driver on MS Windows hosts
        'mssql' => 'FastOrm\Driver\MSSQL\Connection', // older MSSQL driver on MS Windows hosts
        'dblib' => 'FastOrm\Driver\MSSQL\Connection', // dblib drivers on GNU/Linux (and maybe other OSes) hosts
        'oci' => 'FastOrm\Driver\Oracle\Connection', // Oracle driver
        'cubrid' => 'FastOrm\Driver\CUBRID\Connection', // CUBRID
    ];
    /**
     * @var string
     */
    private $charset;

    public function __construct(string $charset = null)
    {
        $this->charset = $charset;
    }

    /**
     * @param $dsn
     * @param $username
     * @param $password
     * @param array $options
     * @return ConnectionInterface
     * @throws NotSupportedException
     */
    public function __invoke($dsn, $username = null, $password = null, array $options = []): ConnectionInterface
    {
        $driver = explode(':', $dsn)[0];
        if (!$classname = static::$driverMap[$driver] ?? null) {
            throw new NotSupportedException();
        }
        /** @var AbstractConnection $instance */
        $instance = new $classname($dsn, $username, $password, $options);
        $this->charset && $instance->setCharset($this->charset);
        return $instance;
    }
}
