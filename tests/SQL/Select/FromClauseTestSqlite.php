<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Select;

use Borodulin\ORM\PdoCommand\DbException;
use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\Tests\TestCase;

class FromClauseTestSqlite extends TestCase
{
    public function testRightJoin(): void
    {
        $this->expectException(DbException::class);
        (new SelectQuery($this->db))
            ->from('Track')->as('t')
            ->rightJoin('Genre')->alias('g')->onColumns('g.GenreId', 't.GenreId')
            ->limit(10)
            ->fetch();
    }

    public function testFullJoin(): void
    {
        $this->expectException(DbException::class);
        (new SelectQuery($this->db))
            ->from('Track')->as('t')
            ->fullJoin('Genre')->alias('g')->onColumns('g.GenreId', 't.GenreId')
            ->limit(10)
            ->fetch();
    }
}
