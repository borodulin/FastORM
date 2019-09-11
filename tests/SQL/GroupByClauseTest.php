<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;


use FastOrm\NotSupportedException;
use FastOrm\SQL\Expression;
use FastOrm\SQL\Query;
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
        $count = (int)(new Query())
            ->select('count(1)')
            ->from('genres')
            ->prepare($connection)
            ->fetch()->scalar();
        $command = (new Query())
            ->select(['GenreId', 'count(1) as cnt'])
            ->from('tracks')->alias('t')
            ->groupBy(['GenreId'])
            ->prepare($connection);
        $rows = $command->fetch()->all();
        $this->assertCount($count, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testString()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->select(['GenreId', 'MediaTypeId', 'count(1) as cnt'])
            ->from('tracks')->alias('t')
            ->groupBy('GenreId, MediaTypeId')
            ->prepare($connection);
        $rows = $command->fetch()->all();
        $this->assertCount(38, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testExpression()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->select(['GenreId', 'MediaTypeId', 'count(1) as cnt'])
            ->from('tracks')->alias('t')
            ->groupBy(new Expression('GenreId, MediaTypeId'))
            ->prepare($connection);
        $rows = $command->fetch()->all();
        $this->assertCount(38, $rows);
    }
}
