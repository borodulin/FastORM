<?php

declare(strict_types=1);

namespace FastOrm\Tests;

use FastOrm\Connection;
use FastOrm\ConnectionInterface;
use FastOrm\NotSupportedException;
use PDO;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @throws NotSupportedException
     */
    protected function setUp(): void
    {
        static $connection;
        if (!$connection) {
            $connection = $this->createConnection('sqlite::memory:');
        }
        $this->connection = $connection;
    }

    /**
     * @param $dsn
     * @return ConnectionInterface
     * @throws NotSupportedException
     */
    protected function createConnection($dsn): ConnectionInterface
    {
        $connection = new Connection($dsn);
        $pdo = $connection->getPdo();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = file_get_contents(__DIR__ . '/db/chinook_sqlite.sql');
        $pdo->exec($sql);
        return $connection;
    }
}
