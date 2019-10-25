<?php

declare(strict_types=1);

namespace FastOrm\Tests;

use FastOrm\ConnectionInterface;
use FastOrm\NotSupportedException;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var ConnectionInterface
     */
    protected $db;

    /**
     * @throws NotSupportedException
     */
    protected function setUp(): void
    {
        static $connection;
        if (!$connection) {
            $connection = $this->createConnection();
        }
        $this->db = $connection;
    }

    /**
     * @param $dsn
     * @return ConnectionInterface
     * @throws NotSupportedException
     */
    protected function createConnection(): ConnectionInterface
    {
        return (new TestConnectionFactory())->create();
//
//        $connection = new Connection('sqlite::memory:');
//        $pdo = $connection->getPdo();
//        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        $sql = file_get_contents(__DIR__ . '/db/chinook_sqlite.sql');
//        $pdo->exec($sql);
//        return $connection;
    }
}
