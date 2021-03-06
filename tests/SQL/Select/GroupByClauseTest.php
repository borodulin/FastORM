<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Select;

use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\SQL\Expression;
use Borodulin\ORM\Tests\TestCase;

class GroupByClauseTest extends TestCase
{
    public function testGroupBy(): void
    {
        $count = (int) (new SelectQuery($this->db))
            ->select(new Expression('count(1)'))
            ->from('Genre')
            ->fetch()
            ->scalar();
        $fetch = (new SelectQuery($this->db))
            ->select(['GenreId', new Expression('count(1) as cnt')])
            ->from('Track')->as('t')
            ->groupBy(['GenreId'])
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount($count, $rows);
    }

    public function testString(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->select(['GenreId', 'MediaTypeId', new Expression('count(1) as cnt')])
            ->from('Track')->as('t')
            ->groupBy(['GenreId', 'MediaTypeId'])
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(38, $rows);
    }

    public function testExpression(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->select(['GenreId', 'MediaTypeId', new Expression('count(1) as cnt')])
            ->from('Track')->as('t')
            ->groupBy(['GenreId', 'MediaTypeId'])
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(38, $rows);
    }
}
