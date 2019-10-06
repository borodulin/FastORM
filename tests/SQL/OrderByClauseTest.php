<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class OrderByClauseTest extends TestCase
{
    use TestConnectionTrait;

    public function testOrderBy()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Track')->as('t')
            ->limit(5)
            ->orderBy(['TrackId' => SORT_DESC])
            ->fetch();
        $row = $fetch->one();
        $this->assertGreaterThan(100, $row['TrackId']);
    }

    public function testArray()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Track')->as('t')
            ->limit(5)
            ->orderBy(['TrackId', 'Name' => SORT_DESC])
            ->fetch();
        $row = $fetch->one();
        $this->assertEquals(1, $row['TrackId']);
    }

    public function testString()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Track')->as('t')
            ->limit(5)
            ->orderBy('TrackId, Name desc')
            ->fetch();
        $row = $fetch->one();
        $this->assertEquals(1, $row['TrackId']);
    }

    public function testExpression()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Track')->as('t')
            ->limit(5)
            ->orderBy(new Expression('TrackId asc'))
            ->fetch();
        $row = $fetch->one();
        $this->assertEquals(1, $row['TrackId']);
    }
}
