<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;


use FastOrm\Exception;
use FastOrm\NotSupportedException;
use FastOrm\Tests\DummyEventDispatcher;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     * @throws Exception
     */
    public function testDispatcher()
    {
        $dispatcher = new DummyEventDispatcher();
        $connection = $this->createConnection();
        $connection->setEventDispatcher($dispatcher);
        $tran = $connection->beginTransaction();
        $tran->commit();
        $this->assertCount(3, $dispatcher->getDispatched());
    }
}
