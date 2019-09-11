<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\Command\Command;
use FastOrm\Command\DbException;
use FastOrm\Exception;
use FastOrm\NotSupportedException;
use FastOrm\SQL\Query;
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
        $nameCommand = (new Query())
            ->select('Title')
            ->from('albums')
            ->where()->equal('AlbumId', 1)
            ->prepare($connection);
        $oldName = $nameCommand->fetch()->scalar();
        $tran = $connection->beginTransaction();
        $command = new Command($connection->getPdo(), 'update albums set Title = :t where AlbumId=:id');
        $cnt = $command->execute(['t' => 'test', 'id' => 1]);
        $this->assertEquals($cnt, 1);
        $newName = $nameCommand->fetch()->scalar();
        $this->assertEquals('test', $newName);
        $tran->rollBack();
        $newName = $nameCommand->fetch()->scalar();
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
        $nameCommand = (new Query())
            ->select('Title')
            ->from('albums')
            ->where()->equal('AlbumId', 1)
            ->prepare($connection);
        $oldName = $nameCommand->fetch()->scalar();
        $tran = $connection->beginTransaction();
        $command = new Command($connection->getPdo(), 'update albums set Title = :t where AlbumId=:id');
        $cnt = $command->execute(['t' => 'test', 'id' => 1]);
        $this->assertEquals($cnt, 1);
        $tran->commit();
        $newName = $nameCommand->fetch()->scalar();
        $this->assertEquals('test', $newName);
        $command->execute(['t' => $oldName, 'id' => 1]);
        $newName = $nameCommand->fetch()->scalar();
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
