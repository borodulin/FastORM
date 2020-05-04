<?php

declare(strict_types=1);

namespace FastOrm\Driver\Sqlite;

use FastOrm\Driver\AbstractDriver;
use FastOrm\NotSupportedException;
use FastOrm\Transaction;
use PDO;

class Driver extends AbstractDriver
{
    /**
     * @throws NotSupportedException
     */
    public function setTransactionIsolationLevel(PDO $pdo, string $isolationLevel): void
    {
        if (Transaction::SERIALIZABLE === $isolationLevel) {
            $pdo->exec('PRAGMA read_uncommitted = False;');
        } elseif (Transaction::READ_UNCOMMITTED === $isolationLevel) {
            $pdo->exec('PRAGMA read_uncommitted = True;');
        } else {
            throw new NotSupportedException('Sqlite3  only supports transaction isolation levels READ UNCOMMITTED and SERIALIZABLE.');
        }
    }
}
