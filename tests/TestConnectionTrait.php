<?php

declare(strict_types=1);

namespace FastOrm\Tests;

use FastOrm\Connection;
use FastOrm\NotSupportedException;
use PDO;

trait TestConnectionTrait
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @throws NotSupportedException
     */
    protected function setUp(): void
    {
        static $connection;
        if (!$connection) {
            $connection = new Connection('sqlite::memory:');
            $pdo = $connection->getPdo();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = file_get_contents(__DIR__ . '/db/chinook_sqlite.sql');
            $pdo->exec($sql);
        }
        $this->connection = $connection;
    }
}
