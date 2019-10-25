<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\PdoCommand\DbException;
use FastOrm\PdoCommand\PdoValue;
use FastOrm\PdoCommand\Statement;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestCase;
use PDO;

class StatementTest extends TestCase
{
    /**
     * @throws DbException
     */
    public function testErrorQuery()
    {
        $this->expectException(DbException::class);
        (new Statement($this->db->getPdo(), 'select * from bad_table_name'))
            ->execute();
    }

    /**
     */
    public function testErrorParams()
    {
        $this->expectException(DbException::class);
        (new SelectQuery($this->db))
            ->from('Album')
            ->where()->equal('AlbumId', ':p1')
            ->fetch()
            ->all(['p2' => 1]);
    }

    /**
     */
    public function testPdoValue()
    {
        $all = (new SelectQuery($this->db))
            ->from('Album')
            ->where()->equal('AlbumId', ':p1')
            ->fetch()
            ->all(['p1' => new PdoValue(1, PDO::PARAM_STR)]);
        $this->assertCount(1, $all);
    }
}
