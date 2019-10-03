<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\PdoCommand\DbException;
use FastOrm\NotSupportedException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\DummyLogger;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws DbException
     * @throws NotSupportedException
     */
    public function testLogger()
    {
        $logger = new DummyLogger();
        $connection = $this->createConnection();
        $connection->setLogger($logger);
        $tran = $connection->beginTransaction();
        $tran->commit();
        $this->assertCount(1, $logger->getLogs());
        $query = new SelectQuery($connection);
        $query->setLogger($logger);
        $query->select('1')->fetch()->scalar();
        $this->assertCount(1, $logger->getLogs());
    }
}
