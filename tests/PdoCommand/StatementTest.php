<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\PdoCommand\DbException;
use FastOrm\PdoCommand\PdoValue;
use FastOrm\PdoCommand\Statement;
use FastOrm\Tests\TestCase;
use PDO;

class StatementTest extends TestCase
{
    /**
     * @throws DbException
     */
    public function testErrorOptions()
    {
        $this->expectException(DbException::class);
        (new Statement(
            $this->connection->getPdo(),
            'select * from Album',
            [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]
        ))
            ->execute();
    }

    /**
     * @throws DbException
     */
    public function testErrorQuery()
    {
        $this->expectException(DbException::class);
        (new Statement($this->connection->getPdo(), 'select * from albums11'))
            ->execute();
    }

    /**
     * @throws DbException
     */
    public function testErrorExecute()
    {
        $this->expectException(DbException::class);
        (new Statement($this->connection->getPdo(), 'select * from Album where AlbumId=1111111111111111111'))
            ->execute(['p1' => '1222222222222222222'])->fetchAll();
    }

    /**
     * @throws DbException
     */
    public function testErrorParams()
    {
        $this->expectException(DbException::class);
        (new Statement($this->connection->getPdo(), 'select * from Album where AlbumId=:p1'))
            ->execute(['p2' => 1])->fetchAll();
    }

    /**
     * @throws DbException
     */
    public function testPdoValue()
    {
        $all = (new Statement($this->connection->getPdo(), 'select * from Album where AlbumId=:p1'))
            ->execute(['p1' => new PdoValue(1, PDO::PARAM_STR)])->fetchAll();
        $this->assertCount(1, $all);
    }
}
