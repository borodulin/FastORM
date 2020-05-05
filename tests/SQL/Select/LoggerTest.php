<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Select;

use Borodulin\ORM\PdoCommand\DbException;
use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\SQL\Expression;
use Borodulin\ORM\Tests\DummyLogger;
use Borodulin\ORM\Tests\TestCase;

class LoggerTest extends TestCase
{
    /**
     * @throws DbException
     */
    public function testLogger(): void
    {
        $logger = new DummyLogger();
        $this->db->setLogger($logger);
        $tran = $this->db->beginTransaction();
        $tran->commit();
        $this->assertCount(1, $logger->getLogs());
        $query = new SelectQuery($this->db);
        $query->setLogger($logger);
        $query->select(new Expression('1'))->fetch()->scalar();
        $this->assertCount(1, $logger->getLogs());
    }
}
