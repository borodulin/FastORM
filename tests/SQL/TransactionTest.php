<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\PdoCommand\DbException;
use FastOrm\Exception;
use FastOrm\NotSupportedException;
use FastOrm\PdoCommand\Statement;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     * @throws DbException
     */
    public function testRollback()
    {
        $connection = $this->createConnection();
        $nameFetch = (new SelectQuery($connection))
            ->select('Title')
            ->from('albums')
            ->where()->equal('AlbumId', 1)
            ->fetch();
        $oldName = $nameFetch->scalar();
        $tran = $connection->beginTransaction();
        $statement = new Statement($connection->getPdo(), 'update albums set Title = :t where AlbumId=:id');
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
        $connection = $this->createConnection();
        $nameFetch = (new SelectQuery($connection))
            ->select('Title')
            ->from('albums')
            ->where()->equal('AlbumId', 1)
            ->fetch();
        $oldName = $nameFetch->scalar();
        $tran = $connection->beginTransaction();
        $command = new Statement($connection->getPdo(), 'update albums set Title = :t where AlbumId=:id');
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
        $connection = $this->createConnection();
        $tran = $connection->beginTransaction();
        $tran->rollBack();
        $this->expectException(DbException::class);
        $tran->commit();
        $tran->rollBack();
    }
}
