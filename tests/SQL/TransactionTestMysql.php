<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL;

use Borodulin\ORM\NotSupportedException;
use Borodulin\ORM\PdoCommand\DbException;
use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\SQL\Clause\UpdateQuery;
use Borodulin\ORM\Tests\TestCase;
use Borodulin\ORM\Transaction;

class TransactionTestMysql extends TestCase
{
    /**
     * @throws NotSupportedException
     */
    public function testIsolation(): void
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
    public function testSavePoint(): void
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
