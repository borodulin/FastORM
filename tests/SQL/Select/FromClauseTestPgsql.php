<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Select;

use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\Tests\TestCase;

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
