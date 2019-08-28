<?php

declare(strict_types=1);

namespace FastOrm\Driver;

interface SavepointInterface
{
    /**
     * Creates a new savepoint.
     * @param string $name the savepoint name
     */
    public function createSavepoint($name): void;

    /**
     * Releases an existing savepoint.
     * @param string $name the savepoint name
     */
    public function releaseSavepoint(string $name): void;

    /**
     * Rolls back to a previously created savepoint.
     * @param string $name the savepoint name
     */
    public function rollBackSavepoint(string $name): void;
}
