<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\NotSupportedException;
use FastOrm\PdoCommand\DbException;
use FastOrm\PdoCommand\PdoValue;
use FastOrm\PdoCommand\Statement;
use FastOrm\Tests\TestConnectionTrait;
use PDO;
use PHPUnit\Framework\TestCase;

class StatementTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     * @throws DbException
     */
    public function testErrorOptions()
    {
        $this->expectException(DbException::class);
        $db = $this->createConnection();
        (new Statement($db->getPdo(), 'select * from albums', [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]))
            ->execute();
    }

    /**
     * @throws DbException
     * @throws NotSupportedException
     */
    public function testErrorQuery()
    {
        $this->expectException(DbException::class);
        $db = $this->createConnection();
        (new Statement($db->getPdo(), 'select * from albums1'))
            ->execute();
    }

    /**
     * @throws DbException
     * @throws NotSupportedException
     */
    public function testErrorExecute()
    {
        $this->expectException(DbException::class);
        $db = $this->createConnection();
        (new Statement($db->getPdo(), 'select * from albums where AlbumId=1111111111111111111'))
            ->execute(['p1' => '1222222222222222222'])->fetchAll();
    }

    /**
     * @throws DbException
     * @throws NotSupportedException
     */
    public function testErrorParams()
    {
        $this->expectException(DbException::class);
        $db = $this->createConnection();
        (new Statement($db->getPdo(), 'select * from albums where AlbumId=:p1'))
            ->execute(['p2' => 1])->fetchAll();
    }

    /**
     * @throws DbException
     * @throws NotSupportedException
     */
    public function testPdoValue()
    {
        $db = $this->createConnection();
        $all = (new Statement($db->getPdo(), 'select * from albums where AlbumId=:p1'))
            ->execute(['p1' => new PdoValue(1, PDO::PARAM_STR)])->fetchAll();
        $this->assertCount(1, $all);
    }
}
