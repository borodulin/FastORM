<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class OrderByClauseTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     */
    public function testOrderBy()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('tracks')->as('t')
            ->limit(5)
            ->orderBy(['TrackId' => SORT_DESC])
            ->fetch();
        $row = $fetch->one();
        $this->assertGreaterThan(100, $row['TrackId']);
    }

    /**
     * @throws NotSupportedException
     */
    public function testArray()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('tracks')->as('t')
            ->limit(5)
            ->orderBy(['TrackId', 'Name' => SORT_DESC])
            ->fetch();
        $row = $fetch->one();
        $this->assertEquals(1, $row['TrackId']);
    }

    /**
     * @throws NotSupportedException
     */
    public function testString()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('tracks')->as('t')
            ->limit(5)
            ->orderBy('TrackId, Name desc')
            ->fetch();
        $row = $fetch->one();
        $this->assertEquals(1, $row['TrackId']);
    }

    /**
     * @throws NotSupportedException
     */
    public function testExpression()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('tracks')->as('t')
            ->limit(5)
            ->orderBy(new Expression('TrackId asc'))
            ->fetch();
        $row = $fetch->one();
        $this->assertEquals(1, $row['TrackId']);
    }
}
