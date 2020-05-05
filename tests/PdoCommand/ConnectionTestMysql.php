<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\PdoCommand;

use Borodulin\ORM\NotSupportedException;
use Borodulin\ORM\PdoCommand\DbException;
use Borodulin\ORM\PdoCommand\Statement;
use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\Tests\TestCase;
use Borodulin\ORM\Transaction;

class ConnectionTestMysql extends TestCase
{
    /**
     * @throws DbException
     * @throws NotSupportedException
     */
    public function testIsolationLevel(): void
    {
        $db1 = $this->createConnection();
        $db2 = $this->createConnection();
        $db1->setTransactionIsolationLevel(Transaction::READ_UNCOMMITTED);
        $db2->setTransactionIsolationLevel(Transaction::READ_UNCOMMITTED);
        $tran = $db2->beginTransaction();
        $count = (new Statement($db2->getPdo(), 'update Album set Title = :p1 where AlbumId = :p2'))
            ->execute(['p1' => 'test', 'p2' => 1])
            ->rowCount();
        $this->assertEquals($count, 1);
        $title = (new SelectQuery($db1))
            ->select('Title')
            ->from('Album')
            ->where()->equal('AlbumId', 1)
            ->fetch()
            ->scalar();
        $this->assertEquals('test', $title);
        $tran->rollBack();
    }
}
