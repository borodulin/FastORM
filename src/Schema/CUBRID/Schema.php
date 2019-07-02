<?php


namespace FastOrm\Schema\CUBRID;

use FastOrm\Schema\SchemaInterface;
use PDO;

class Schema implements SchemaInterface
{
    public function supportsSavepoint()
    {
        // TODO: Implement supportsSavepoint() method.
    }

    public function createSavepoint($name)
    {
        // TODO: Implement createSavepoint() method.
    }

    public function setTransactionIsolationLevel(string $isolationLevel): void
    {
        // TODO: Implement setTransactionIsolationLevel() method.
    }

    public function releaseSavepoint(string $name)
    {
        // TODO: Implement releaseSavepoint() method.
    }

    public function rollBackSavepoint(string $name)
    {
        // TODO: Implement rollBackSavepoint() method.
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
