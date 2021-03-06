<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Select;

use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\Tests\TestCase;

class ImmutableTest extends TestCase
{
    public function testSelect(): void
    {
        $query1 = (new SelectQuery($this->db))
            ->from('Album');
        $query2 = clone $query1;
        $countAll1 = \count($query1->fetch()->column());
        $countAll2 = (int) $query2->select('count(1)')->fetch()->scalar();
        $this->assertEquals($countAll1, $countAll2);
        $count = \count($query1->limit(100));
        $this->assertEquals(100, $count);
    }

    public function testWhere(): void
    {
        $query1 = (new SelectQuery($this->db))
            ->from('Album')
            ->select('AlbumId')
            ->where()->equal('AlbumId', 1);
        $query2 = clone $query1;
        $query2->where()->equal('AlbumId', 2);
        $this->assertCount(0, $query2);
        $this->assertCount(1, $query1);
    }
}
