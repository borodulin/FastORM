<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Select;

use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\Tests\TestCase;

class OrderByClauseTest extends TestCase
{
    public function testOrderBy(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->from('Track')->as('t')
            ->limit(5)
            ->orderBy(['TrackId' => SORT_DESC])
            ->fetch();
        $row = $fetch->one();
        $this->assertGreaterThan(100, $row['TrackId']);
    }

    public function testArray(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->from('Track')->as('t')
            ->limit(5)
            ->orderBy(['TrackId', 'Name' => SORT_DESC])
            ->fetch();
        $row = $fetch->one();
        $this->assertEquals(1, $row['TrackId']);
    }

    public function testString(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->from('Track')->as('t')
            ->limit(5)
            ->orderBy('TrackId, Name desc')
            ->fetch();
        $row = $fetch->one();
        $this->assertEquals(1, $row['TrackId']);
    }
}
