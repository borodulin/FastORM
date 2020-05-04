<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\NotSupportedException;
use FastOrm\PdoCommand\DbException;
use FastOrm\Tests\DummyEventDispatcher;
use FastOrm\Tests\TestCase;

class EventTest extends TestCase
{
    /**
     * @throws NotSupportedException
     * @throws DbException
     */
    public function testDispatcher(): void
    {
        $dispatcher = new DummyEventDispatcher();
        $connection = $this->db;
        $connection->setEventDispatcher($dispatcher);
        $tran = $connection->beginTransaction();
        $tran->commit();
        $this->assertCount(2, $dispatcher->getDispatched());
    }
}
