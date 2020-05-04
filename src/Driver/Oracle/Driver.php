<?php

declare(strict_types=1);

namespace FastOrm\Driver\Oracle;

use FastOrm\Driver\AbstractDriver;
use FastOrm\Driver\SavepointInterface;
use PDO;

class Driver extends AbstractDriver implements SavepointInterface
{
    /**
     * Creates a new savepoint.
     *
     * @param string $name the savepoint name
     */
    public function createSavepoint(PDO $pdo, string $name): void
    {
        $pdo->exec("SAVEPOINT $name");
    }

    /**
     * Releases an existing savepoint.
     *
     * @param string $name the savepoint name
     */
    public function releaseSavepoint(PDO $pdo, string $name): void
    {
        // does nothing as Oracle does not support this
    }

    /**
     * Rolls back to a previously created savepoint.
     *
     * @param string $name the savepoint name
     */
    public function rollBackSavepoint(PDO $pdo, string $name): void
    {
        $pdo->exec("ROLLBACK TO SAVEPOINT $name");
    }
}
