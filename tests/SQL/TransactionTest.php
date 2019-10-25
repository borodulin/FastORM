<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\PdoCommand\DbException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Clause\UpdateQuery;
use FastOrm\Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     */
    public function testRollback()
    {
        $nameFetch = (new SelectQuery($this->db))
            ->select('Title')
            ->from('Album')
            ->where()->equal('AlbumId', 1)
            ->fetch();
        $oldName = $nameFetch->scalar();
        $update = (new UpdateQuery($this->db))
            ->update('Album')
            ->set(['Title' => 'Test1'])
            ->where()->equal('AlbumId', 1);
        $tran = $this->db->beginTransaction();
        $count = $update->execute();
        $this->assertEquals(1, $count);
        $newName = $nameFetch->scalar();
        $this->assertEquals('Test1', $newName);
        $tran->rollBack();
        $newName = $nameFetch->scalar();
        $this->assertEquals($oldName, $newName);
    }

    /**
     * @throws DbException
     */
    public function testCommit()
    {
        $nameFetch = (new SelectQuery($this->db))
            ->select('Title')
            ->from('Album')
            ->where()->equal('AlbumId', 1)
            ->fetch();
        $oldName = $nameFetch->scalar();
        $tran = $this->db->beginTransaction();
        $count = (new UpdateQuery($this->db))
            ->update('Album')
            ->set(['Title' => 'Test1'])
            ->where()->equal('AlbumId', 1)
            ->execute();
        $this->assertEquals($count, 1);
        $tran->commit();
        $newName = $nameFetch->scalar();
        $this->assertEquals('Test1', $newName);
        $count = (new UpdateQuery($this->db))
            ->update('Album')
            ->set(['Title' => $oldName])
            ->where()->equal('AlbumId', 1)
            ->execute();
        $this->assertEquals($count, 1);
        $newName = $nameFetch->scalar();
        $this->assertEquals($oldName, $newName);
    }

    /**
     * @throws DbException
     */
    public function testError()
    {
        $tran = $this->db->beginTransaction();
        $tran->rollBack();
        $this->expectException(DbException::class);
        $tran->commit();
        $tran->rollBack();
    }
}
