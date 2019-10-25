<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\PdoCommand\DbException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Clause\UpdateQuery;
use FastOrm\Tests\TestCase;
use FastOrm\Transaction;

class TransactionTestMysql extends TestCase
{
    /**
     * @throws NotSupportedException
     */
    public function testIsolation()
    {
        $db1 = $this->createConnection();
        $db2 = $this->createConnection();
        $db1->setTransactionIsolationLevel(Transaction::READ_UNCOMMITTED);
        $db2->setTransactionIsolationLevel(Transaction::READ_UNCOMMITTED);
        $tran = $db2->beginTransaction();
        $count = (new UpdateQuery($db2))
            ->update('Album')
            ->set(['Title' => 'Test1'])
            ->where()->equal('AlbumId', 1)
            ->execute();
        $this->assertEquals($count, 1);
        $title = (new SelectQuery($db1))
            ->select('Title')
            ->from('Album')
            ->where()->equal('AlbumId', 1)
            ->fetch()
            ->scalar();
        $this->assertEquals('Test1', $title);
        $tran->rollBack();
    }

    /**
     * @throws NotSupportedException
     * @throws DbException
     */
    public function testSavePoint()
    {
        $db1 = $this->createConnection();
        $tran1 = $db1->beginTransaction();
        $count = (new UpdateQuery($db1))
            ->update('Album')
            ->set(['Title' => 'Test1'])
            ->where()->equal('AlbumId', 1)
            ->execute();
        $this->assertEquals(1, $count);
        $tran2 = $db1->beginTransaction();
        $count = (new UpdateQuery($db1))
            ->update('Album')
            ->set(['Title' => 'Test2'])
            ->where()->equal('AlbumId', 1)
            ->execute();
        $this->assertEquals(1, $count);
        $tran2->commit();
        $tran1->rollBack();
    }
}
