<?php

declare(strict_types=true);

namespace FastOrm\Schema;

use FastOrm\Exception;

class SchemaFactory
{
    private $schemaMap = [
        'pgsql' => 'FastOrm\Schema\Postgres\Schema', // PostgreSQL
        'mysqli' => 'FastOrm\Schema\MySQL\Schema', // MySQL
        'mysql' => 'FastOrm\Schema\MySQL\Schema', // MySQL
        'sqlite' => 'FastOrm\Schema\Sqlite\Schema', // sqlite 3
        'sqlite2' => 'FastOrm\Schema\Sqlite\Schema', // sqlite 2
        'sqlsrv' => 'FastOrm\Schema\MSSQL\Schema', // newer MSSQL driver on MS Windows hosts
        'oci' => 'FastOrm\Schema\Oracle\Schema', // Oracle driver
        'mssql' => 'FastOrm\Schema\MSSQL\Schema', // older MSSQL driver on MS Windows hosts
        'dblib' => 'FastOrm\Schema\MSSQL\Schema', // dblib drivers on GNU/Linux (and maybe other OSes) hosts
        'cubrid' => 'FastOrm\Schema\CUBRID\Schema', // CUBRID
    ];

    private $driverName;
    private $dsn;

    public function __construct(array $schemaMap = [])
    {
        $this->schemaMap = array_merge($this->schemaMap, $schemaMap);
    }

    public function __invoke(string $dsn, string $username, string $password, array $attributes = [])
    {
        if (($pos = strpos($dsn, ':')) !== false) {
            $driverName = strtolower(substr($dsn, 0, $pos));
            if (!isset($this->schemaMap[$driverName])) {
                throw new Exception();
            }
//            $schema = new $this->schemaMap[$driverName];
        }
    }

    public function getDriverName()
    {
        if ($this->driverName === null) {
            if (($pos = strpos($this->dsn, ':')) !== false) {
                $this->driverName = strtolower(substr($this->dsn, 0, $pos));
            }
        }
        return $this->driverName;
    }

//    protected function initConnection()
//    {
//        $pdo = $this->schema->getPDO();
//        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        if ($this->emulatePrepare !== null && constant('PDO::ATTR_EMULATE_PREPARES')) {
//            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, $this->emulatePrepare);
//        }
//        if ($this->charset !== null && in_array($this->getDriverName(), ['pgsql', 'mysql', 'mysqli', 'cubrid'], true)) {
//            $this->pdo->exec('SET NAMES ' . $this->pdo->quote($this->charset));
//        }
//        $this->trigger(self::EVENT_AFTER_OPEN);
//    }
}
