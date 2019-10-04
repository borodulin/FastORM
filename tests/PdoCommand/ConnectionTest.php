<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\NotSupportedException;
use FastOrm\PdoCommand\DbException;
use FastOrm\PdoCommand\Statement;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestConnectionTrait;
use FastOrm\Transaction;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     * @throws DbException
     */
    public function testIsolationLevel()
    {
        $db1 = $this->createConnection();
        $db2 = $this->createConnection();
        $db1->setTransactionIsolationLevel(Transaction::READ_COMMITTED);
        $db2->setTransactionIsolationLevel(Transaction::READ_COMMITTED);
        $tran = $db2->beginTransaction();
        $count = (new Statement($db2->getPdo(), 'update albums set Title = :p1 where AlbumId = :p2'))
            ->execute(['p1' => 'test','p2' => 1])
            ->rowCount();
        $this->assertEquals($count, 1);
        $title = (new SelectQuery($db1))
            ->select('Title')->from('albums')->where()->equal('AlbumId', 1)
            ->fetch()->scalar();
        $this->assertNotEquals('test', $title);
        $tran->rollBack();
    }
}
