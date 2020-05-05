<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Select;

use Borodulin\ORM\NotSupportedException;
use Borodulin\ORM\PdoCommand\DbException;
use Borodulin\ORM\Tests\DummyEventDispatcher;
use Borodulin\ORM\Tests\TestCase;

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
