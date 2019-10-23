<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\PdoCommand\DbException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\DummyLogger;
use FastOrm\Tests\TestCase;

class LoggerTest extends TestCase
{
    /**
     * @throws DbException
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
        $query->select(new Expression('1'))->fetch()->scalar();
        $this->assertCount(1, $logger->getLogs());
    }
}
