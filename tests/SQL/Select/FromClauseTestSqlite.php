<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\PdoCommand\DbException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestCase;

class FromClauseTestSqlite extends TestCase
{
    public function testRightJoin()
    {
        $this->expectException(DbException::class);
        (new SelectQuery($this->connection))
            ->from('Track')->as('t')
            ->rightJoin('Genre')->alias('g')->onColumns('g.GenreId', 't.GenreId')
            ->limit(10)
            ->fetch();
    }

    public function testFullJoin()
    {
        $this->expectException(DbException::class);
        (new SelectQuery($this->connection))
            ->from('Track')->as('t')
            ->fullJoin('Genre')->alias('g')->onColumns('g.GenreId', 't.GenreId')
            ->limit(10)
            ->fetch();
    }
}
