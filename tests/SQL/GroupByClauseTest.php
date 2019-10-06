<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TestCase;

class GroupByClauseTest extends TestCase
{
    public function testGroupBy()
    {
        $count = (int)(new SelectQuery($this->connection))
            ->select('count(1)')
            ->from('Genre')
            ->fetch()
            ->scalar();
        $fetch = (new SelectQuery($this->connection))
            ->select(['GenreId', 'count(1) as cnt'])
            ->from('Track')->as('t')
            ->groupBy(['GenreId'])
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount($count, $rows);
    }

    public function testString()
    {
        $fetch = (new SelectQuery($this->connection))
            ->select(['GenreId', 'MediaTypeId', 'count(1) as cnt'])
            ->from('Track')->as('t')
            ->groupBy('GenreId, MediaTypeId')
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(38, $rows);
    }

    public function testExpression()
    {
        $fetch = (new SelectQuery($this->connection))
            ->select(['GenreId', 'MediaTypeId', 'count(1) as cnt'])
            ->from('Track')->as('t')
            ->groupBy(new Expression('GenreId, MediaTypeId'))
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(38, $rows);
    }
}
