<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\Exception;
use FastOrm\NotSupportedException;
use FastOrm\PdoCommand\DbException;
use FastOrm\PdoCommand\Statement;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * @throws DbException
     * @throws NotSupportedException
     */
    public function testRollback()
    {
        $nameFetch = (new SelectQuery($this->connection))
            ->select('Title')
            ->from('Album')
            ->where()->equal('AlbumId', 1)
            ->fetch();
        $oldName = $nameFetch->scalar();
        $tran = $this->connection->beginTransaction();
        $statement = new Statement($this->connection->getPdo(), 'update Album set Title = :t where AlbumId=:id');
        $cnt = $statement->execute(['t' => 'test', 'id' => 1])->rowCount();
        $this->assertEquals($cnt, 1);
        $newName = $nameFetch->scalar();
        $this->assertEquals('test', $newName);
        $tran->rollBack();
        $newName = $nameFetch->scalar();
        $this->assertEquals($oldName, $newName);
    }

    /**
     * @throws DbException
     * @throws NotSupportedException
     * @throws Exception
     */
    public function testCommit()
    {
        $nameFetch = (new SelectQuery($this->connection))
            ->select('Title')
            ->from('Album')
            ->where()->equal('AlbumId', 1)
            ->fetch();
        $oldName = $nameFetch->scalar();
        $tran = $this->connection->beginTransaction();
        $command = new Statement($this->connection->getPdo(), 'update Album set Title = :t where AlbumId=:id');
        $cnt = $command->execute(['t' => 'test', 'id' => 1])->rowCount();
        $this->assertEquals($cnt, 1);
        $tran->commit();
        $newName = $nameFetch->scalar();
        $this->assertEquals('test', $newName);
        $command->execute(['t' => $oldName, 'id' => 1]);
        $newName = $nameFetch->scalar();
        $this->assertEquals($oldName, $newName);
    }

    /**
     * @throws NotSupportedException
     * @throws Exception
     */
    public function testError()
    {
        $tran = $this->connection->beginTransaction();
        $tran->rollBack();
        $this->expectException(DbException::class);
        $tran->commit();
        $tran->rollBack();
    }
}
