<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestCase;

class ImmutableTest extends TestCase
{
    public function testSelect()
    {
        $query1 = (new SelectQuery($this->connection))
            ->from('Album')->select('AlbumId');
        $query2 = clone $query1;
        $countAll1 = count($query1);
        $countAll2 = (int)$query2->select('count(1)')->fetch()->scalar();
        $this->assertEquals($countAll1, $countAll2);
        $count = count($query1->limit(100));
        $this->assertEquals(100, $count);
    }

    public function testWhere()
    {
        $query1 = (new SelectQuery($this->connection))
            ->from('Album')
            ->select('AlbumId')
            ->where()->equal('AlbumId', 1);
        $query2 = clone $query1;
        $query2->where()->equal('AlbumId', 2);
        $this->assertCount(0, $query2);
        $this->assertCount(1, $query1);
    }
}
