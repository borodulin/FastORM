<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\PdoCommand\DbException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\DummyLogger;
use FastOrm\Tests\TestCase;

class LoggerTest extends TestCase
{
    /**
     * @throws DbException
     * @throws NotSupportedException
     */
    public function testLogger()
    {
        $logger = new DummyLogger();
        $this->connection->setLogger($logger);
        $tran = $this->connection->beginTransaction();
        $tran->commit();
        $this->assertCount(1, $logger->getLogs());
        $query = new SelectQuery($this->connection);
        $query->setLogger($logger);
        $query->select('1')->fetch()->scalar();
        $this->assertCount(1, $logger->getLogs());
    }
}
