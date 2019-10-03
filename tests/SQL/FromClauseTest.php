<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\PdoCommand\DbException;
use FastOrm\NotSupportedException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class FromClauseTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     */
    public function testEmptyFrom()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->select('1')
            ->fetch();
        $one = $fetch->scalar();
        $this->assertEquals(1, $one);
    }

    /**
     * @throws NotSupportedException
     */
    public function testJoins()
    {
        $connection = $this->createConnection();
        $command = (new SelectQuery($connection))
            ->from('tracks')->alias('t')
            ->innerJoin('genres')->alias('g')->on('g.GenreID=t.GenreId')
            ->innerJoin('media_types')->alias('mt')->on('mt.MediaTypeId=t.MediaTypeId')
            ->limit(10)
            ->fetch();
        $all = $command->all();
        $this->assertCount(10, $all);
    }

    /**
     * @throws NotSupportedException
     */
    public function testSubQuery()
    {
        $connection = $this->createConnection();
        $query = (new SelectQuery($connection))
            ->from('tracks')->alias('t')
            ->limit(10);
        $fetch = (new SelectQuery($connection))
            ->from($query)->alias('s')
            ->fetch();
        $all = $fetch->all();
        $this->assertCount(10, $all);
    }

    /**
     * @throws NotSupportedException
     */
    public function testFromAlias()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('tracks t')
            ->limit(10)
            ->fetch();
        $all = $fetch->all();
        $this->assertCount(10, $all);
    }

    /**
     * @throws NotSupportedException
     */
    public function testLeftJoin()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('tracks')->alias('t')
            ->leftJoin('genres')->alias('g')->on('g.GenreID=t.GenreId')
            ->limit(10)
            ->fetch();
        $all = $fetch->all();
        $this->assertCount(10, $all);
    }

    /**
     * @throws NotSupportedException
     */
    public function testRightJoin()
    {
        $connection = $this->createConnection();
        $this->expectException(DbException::class);
        (new SelectQuery($connection))
            ->from('tracks')->alias('t')
            ->rightJoin('genres')->alias('g')->on('g.GenreID=t.GenreId')
            ->limit(10)
            ->fetch();
    }

    /**
     * @throws NotSupportedException
     */
    public function testFullJoin()
    {
        $connection = $this->createConnection();
        $this->expectException(DbException::class);
        (new SelectQuery($connection))
            ->from('tracks')->alias('t')
            ->fullJoin('genres')->alias('g')->on('g.GenreID=t.GenreId')
            ->limit(10)
            ->fetch();
    }

    /**
     * @throws NotSupportedException
     */
    public function testCustomJoin()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('tracks')->alias('t')
            ->join('genres g', 'left outer join')->on('g.GenreID=t.GenreId')
            ->limit(10)
            ->fetch();
        $all = $fetch->all();
        $this->assertCount(10, $all);
    }
}
