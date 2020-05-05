<?php

declare(strict_types=1);

namespace Borodulin\ORM\Driver\Sqlite;

use Borodulin\ORM\Driver\AbstractDriver;
use Borodulin\ORM\NotSupportedException;
use Borodulin\ORM\Transaction;
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
