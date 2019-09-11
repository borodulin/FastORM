<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\Command\DbException;
use FastOrm\NotSupportedException;
use FastOrm\SQL\Query;
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
        $query = new Query();
        $query->setLogger($logger);
        $query->select('1')->prepare($connection)->fetch()->scalar();
        $this->assertCount(1, $logger->getLogs());
    }
}
