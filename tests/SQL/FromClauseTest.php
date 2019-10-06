<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\PdoCommand\DbException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class FromClauseTest extends TestCase
{
    use TestConnectionTrait;

    public function testEmptyFrom()
    {
        $fetch = (new SelectQuery($this->connection))
            ->select('1')
            ->fetch();
        $one = $fetch->scalar();
        $this->assertEquals(1, $one);
    }

    public function testJoins()
    {
        $command = (new SelectQuery($this->connection))
            ->from('Track')->as('t')
            ->innerJoin('Genre')->alias('g')->on('g.GenreID=t.GenreId')
            ->innerJoin('MediaType')->alias('mt')->on('mt.MediaTypeId=t.MediaTypeId')
            ->limit(10)
            ->fetch();
        $all = $command->all();
        $this->assertCount(10, $all);
    }

    public function testSubQuery()
    {
        $query = (new SelectQuery($this->connection))
            ->from('Track')->as('t')
            ->limit(10);
        $fetch = (new SelectQuery($this->connection))
            ->from($query)->as('s')
            ->fetch();
        $all = $fetch->all();
        $this->assertCount(10, $all);
    }

    public function testFromAlias()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Track t')
            ->limit(10)
            ->fetch();
        $all = $fetch->all();
        $this->assertCount(10, $all);
    }

    public function testLeftJoin()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Track')->as('t')
            ->leftJoin('Genre')->alias('g')->on('g.GenreID=t.GenreId')
            ->limit(10)
            ->fetch();
        $all = $fetch->all();
        $this->assertCount(10, $all);
    }

    public function testRightJoin()
    {
        $this->expectException(DbException::class);
        (new SelectQuery($this->connection))
            ->from('Track')->as('t')
            ->rightJoin('genres')->alias('g')->on('g.GenreID=t.GenreId')
            ->limit(10)
            ->fetch();
    }

    public function testFullJoin()
    {
        $this->expectException(DbException::class);
        (new SelectQuery($this->connection))
            ->from('Track')->as('t')
            ->fullJoin('Genre')->alias('g')->on('g.GenreID=t.GenreId')
            ->limit(10)
            ->fetch();
    }

    public function testCustomJoin()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Track')->as('t')
            ->join('Genre g', 'left outer join')->on('g.GenreID=t.GenreId')
            ->limit(10)
            ->fetch();
        $all = $fetch->all();
        $this->assertCount(10, $all);
    }
}
