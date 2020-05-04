<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TestCase;

class FromClauseTest extends TestCase
{
    public function testEmptyFrom(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->select(new Expression('1'))
            ->fetch();
        $one = $fetch->scalar();
        $this->assertEquals(1, $one);
    }

    public function testJoins(): void
    {
        $command = (new SelectQuery($this->db))
            ->from('Track')->as('t')
            ->innerJoin('Genre')->alias('g')->onColumns('g.GenreId', 't.GenreId')
            ->innerJoin('MediaType')->alias('mt')->onColumns('mt.MediaTypeId', 't.MediaTypeId')
            ->limit(10)
            ->fetch();
        $all = $command->all();
        $this->assertCount(10, $all);
    }

    public function testSubQuery(): void
    {
        $query = (new SelectQuery($this->db))
            ->from('Track')->as('t')
            ->limit(10);
        $fetch = (new SelectQuery($this->db))
            ->from($query)->as('s')
            ->fetch();
        $all = $fetch->all();
        $this->assertCount(10, $all);
    }

    public function testFromAlias(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->from('Track t')
            ->limit(10)
            ->fetch();
        $all = $fetch->all();
        $this->assertCount(10, $all);
    }

    public function testLeftJoin(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->from('Track')->as('t')
            ->leftJoin('Genre')->alias('g')->onColumns('g.GenreId', 't.GenreId')
            ->limit(10)
            ->fetch();
        $all = $fetch->all();
        $this->assertCount(10, $all);
    }

    public function testCustomJoin(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->from('Track')->as('t')
            ->join('Genre g', 'left outer join')->onColumns('g.GenreId', 't.GenreId')
            ->limit(10)
            ->fetch();
        $all = $fetch->all();
        $this->assertCount(10, $all);
    }
}
