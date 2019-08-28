<?php

declare(strict_types=1);

namespace FastOrm\Driver\Oracle;


use FastOrm\Driver\AbstractConnection;
use FastOrm\Driver\SavepointInterface;

class Connection extends AbstractConnection implements SavepointInterface
{

    /**
     * Creates a new savepoint.
     * @param string $name the savepoint name
     */
    public function createSavepoint($name): void
    {
        $this->pdoExec("SAVEPOINT $name");
    }

    /**
     * Releases an existing savepoint.
     * @param string $name the savepoint name
     */
    public function releaseSavepoint(string $name): void
    {
        // does nothing as Oracle does not support this
    }

    /**
     * Rolls back to a previously created savepoint.
     * @param string $name the savepoint name
     */
    public function rollBackSavepoint(string $name): void
    {
        $this->pdoExec("ROLLBACK TO SAVEPOINT $name");
    }
}
