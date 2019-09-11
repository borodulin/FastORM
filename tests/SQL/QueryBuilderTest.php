<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Query;
use FastOrm\SQL\SearchCondition\ConditionInterface;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

/**
 * Class QueryBuilderTest
 * @package FastOrm\Tests\SQL
 */
class QueryBuilderTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     */
    public function testParamBinding()
    {
        $connection = $this->createConnection();
        $query = new Query();
        /** @var ConditionInterface  $expression */
        $command = $query
            ->from('albums')->alias('t1')
            ->where()
            ->expression('1=:p1', [':p1' => 1])
            ->and()->between('AlbumId', ':p1', ':p2')
            ->prepare($connection);
        $fetch = $command->fetch();
        $this->assertCount(0, $fetch->all());
        $fetch = $command->fetch(['p2' => 10]);
        $this->assertCount(10, $fetch->all());
        $fetch = $command->fetch(['p1' => 2]);
        $this->assertCount(0, $fetch->all());
    }

    /**
     * @throws NotSupportedException
     */
    public function testOr()
    {
        $connection = $this->createConnection();
        $query = new Query();
        /** @var ConditionInterface  $expression */
        $command = $query
            ->from('albums')->alias('t1')
            ->where()->equal('AlbumId', 1)
            ->or()->in('AlbumId', [2,3])
            ->and()->expression(function (ConditionInterface $condition) {
                return $condition->in('AlbumId', [1,2])->or()->equal('AlbumId', 3);
            })
            ->prepare($connection);
        $fetch = $command->fetch();
        $all = $fetch->all();
        $this->assertCount(3, $all);
    }

    /**
     * @throws NotSupportedException
     */
    public function testHashCondition()
    {
        $connection = $this->createConnection();
        $query = new Query();
        /** @var ConditionInterface  $expression */
        $command = $query
            ->from('albums')->alias('t1')
            ->where()->hashCondition(['AlbumId' => [1,':tt']])
            ->prepare($connection);
        $fetch = $command->fetch();
        $this->assertCount(1, $fetch->all());
        $fetch = $command->fetch(['tt' => 2]);
        $this->assertCount(2, $fetch->all());
    }

    /**
     * @throws NotSupportedException
     */
    public function testLike()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('tracks')->alias('t')
            ->where()->like('Name', 'rock')
            ->limit(5)
            ->prepare($connection);
        $all = $command->fetch()->all();
        foreach ($all as $row) {
            $this->assertStringContainsStringIgnoringCase('rock', $row['Name']);
        }
    }

    /**
     * @throws NotSupportedException
     */
    public function testOrderBy()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('tracks')->alias('t')
            ->limit(5)
            ->orderBy(['TrackId' => SORT_DESC])
            ->prepare($connection);
        $row = $command->fetch()->one();
        $this->assertGreaterThan(100, $row['TrackId']);
    }

    /**
     * @throws NotSupportedException
     */
    public function testLimit()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('tracks')->alias('t')
            ->limit(5)->offset(10)
            ->orderBy(['TrackId' => SORT_ASC])
            ->prepare($connection);
        $row = $command->fetch()->one();
        $this->assertEquals(11, $row['TrackId']);
    }

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
    public function testHaving()
    {
        $connection = $this->createConnection();
        $count = (int)(new Query())
            ->select('count(1)')
            ->from('genres')
            ->where()->like('Name', 'Rock')
            ->prepare($connection)
            ->fetch()->scalar();
        $command = (new Query())
            ->select(['t.GenreId', 'count(1) as cnt'])
            ->from('tracks t')->alias('t')
            ->innerJoin('genres g')->on('g.GenreId=t.GenreId')
            ->groupBy(['t.GenreId', 'g.Name'])
            ->having()->like('g.Name', 'Rock')
            ->prepare($connection);
        $rows = $command->fetch()->all();
        $this->assertCount($count, $rows);
    }
}
