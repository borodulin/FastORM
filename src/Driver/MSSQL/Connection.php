<?php

declare(strict_types=1);

namespace FastOrm\Driver\MSSQL;

use FastOrm\Driver\AbstractConnection;
use FastOrm\Driver\DbException;
use FastOrm\Driver\SavepointInterface;
use PDO;

class Connection extends AbstractConnection implements SavepointInterface
{
    protected function createPdoInstance(): PDO
    {
        $driverName = explode(':', $this->dsn)[0];
        if ($driverName === 'mssql' || $driverName === 'dblib') {
            $pdoClass = MssqlPDO::class;
        } elseif ($driverName === 'sqlsrv') {
            $pdoClass = SqlsrvPDO::class;
        } else {
            $pdoClass = PDO::class;
        }
        return new $pdoClass($this->dsn, $this->username, $this->password, $this->options);
    }

    /**
     * Creates a new savepoint.
     * @param string $name the savepoint name
     * @throws DbException
     */
    public function createSavepoint($name): void
    {
        $this->pdoExec("SAVE TRANSACTION $name");
    }

    /**
     * Releases an existing savepoint.
     * @param string $name the savepoint name
     */
    public function releaseSavepoint(string $name): void
    {
        // does nothing as MSSQL does not support this
    }

    /**
     * Rolls back to a previously created savepoint.
     * @param string $name the savepoint name
     * @throws DbException
     */
    public function rollBackSavepoint(string $name): void
    {
        $this->pdoExec("ROLLBACK TRANSACTION $name");
    }
}
