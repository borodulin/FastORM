<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestCase;

class FromClauseTestPgsql extends TestCase
{
    public function testRightJoin(): void
    {
        $all = (new SelectQuery($this->db))
            ->from('Track')->as('t')
            ->rightJoin('Genre')->alias('g')->onColumns('g.GenreId', 't.GenreId')
            ->limit(10)
            ->fetch()
            ->all();
        $this->assertCount(10, $all);
    }

    public function testFullJoin(): void
    {
        $all = (new SelectQuery($this->db))
            ->from('Track')->as('t')
            ->fullJoin('Genre')->alias('g')->onColumns('g.GenreId', 't.GenreId')
            ->limit(10)
            ->fetch()
            ->all();
        $this->assertCount(10, $all);
    }
}
