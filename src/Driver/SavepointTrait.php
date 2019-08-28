<?php

declare(strict_types=1);

namespace FastOrm\Driver;

trait SavepointTrait
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
        $this->pdoExec("RELEASE SAVEPOINT $name");
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
