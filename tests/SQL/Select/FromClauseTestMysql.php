<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestCase;

class FromClauseTestMysql extends TestCase
{
    public function testRightJoin()
    {
        $all = (new SelectQuery($this->db))
            ->from('Track')->as('t')
            ->rightJoin('Genre')->alias('g')->onColumns('g.GenreId', 't.GenreId')
            ->limit(10)
            ->fetch()
            ->all();
        $this->assertCount(10, $all);
    }

//    public function testFullJoin()
//    {
//        $all = (new SelectQuery($this->connection))
//            ->from('Track')->as('t')
//            ->fullJoin('Genre')->alias('g')->onColumns('g.GenreId', 't.GenreId')
//            ->limit(10)
//            ->fetch()
//            ->all();
//        $this->assertCount(10, $all);
//    }
}
