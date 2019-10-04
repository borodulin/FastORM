<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;


use FastOrm\NotSupportedException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class GroupByClauseTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     */
    public function testGroupBy()
    {
        $connection = $this->createConnection();
        $count = (int)(new SelectQuery($connection))
            ->select('count(1)')
            ->from('genres')
            ->fetch()
            ->scalar();
        $fetch = (new SelectQuery($connection))
            ->select(['GenreId', 'count(1) as cnt'])
            ->from('tracks')->as('t')
            ->groupBy(['GenreId'])
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount($count, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testString()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->select(['GenreId', 'MediaTypeId', 'count(1) as cnt'])
            ->from('tracks')->as('t')
            ->groupBy('GenreId, MediaTypeId')
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(38, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testExpression()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->select(['GenreId', 'MediaTypeId', 'count(1) as cnt'])
            ->from('tracks')->as('t')
            ->groupBy(new Expression('GenreId, MediaTypeId'))
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(38, $rows);
    }
}
