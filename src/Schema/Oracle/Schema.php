<?php


namespace Schema\Oracle;

use FastOrm\Schema\SavepointInterface;
use FastOrm\Schema\SchemaInterface;
use PDO;

class Schema implements SchemaInterface, SavepointInterface
{
    public function createSavepoint($name): void
    {
        // TODO: Implement createSavepoint() method.
    }

    public function releaseSavepoint(string $name): void
    {
        // TODO: Implement releaseSavepoint() method.
    }

    public function rollBackSavepoint(string $name): void
    {
        // TODO: Implement rollBackSavepoint() method.
    }

    public function setTransactionIsolationLevel(string $isolationLevel): void
    {
        // TODO: Implement setTransactionIsolationLevel() method.
    }

    public function getPDO(): PDO
    {
        // TODO: Implement getPDO() method.
    }

    public function quoteColumnName(string $name): string
    {
        // TODO: Implement quoteColumnName() method.
    }

    public function getPdoType($value)
    {
        // TODO: Implement getPdoType() method.
    }
}
