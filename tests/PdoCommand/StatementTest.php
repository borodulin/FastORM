<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\PdoCommand;

use Borodulin\ORM\PdoCommand\DbException;
use Borodulin\ORM\PdoCommand\PdoValue;
use Borodulin\ORM\PdoCommand\Statement;
use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\Tests\TestCase;
use PDO;

class StatementTest extends TestCase
{
    /**
     * @throws DbException
     */
    public function testErrorQuery(): void
    {
        $this->expectException(DbException::class);
        (new Statement($this->db->getPdo(), 'select * from bad_table_name'))
            ->execute();
    }

    public function testErrorParams(): void
    {
        $this->expectException(DbException::class);
        (new SelectQuery($this->db))
            ->from('Album')
            ->where()->equal('AlbumId', ':p1')
            ->fetch()
            ->all(['p2' => 1]);
    }

    public function testPdoValue(): void
    {
        $all = (new SelectQuery($this->db))
            ->from('Album')
            ->where()->equal('AlbumId', ':p1')
            ->fetch()
            ->all(['p1' => new PdoValue(1, PDO::PARAM_STR)]);
        $this->assertCount(1, $all);
    }
}
