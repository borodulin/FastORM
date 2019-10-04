<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\QueryBuilder;
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
        $query = (new QueryBuilder($connection))->select();
        /** @var ConditionInterface  $expression */
        $fetch = $query
            ->from('albums')->as('t1')
            ->where()
            ->expression('1=:p1', [':p1' => 1])
            ->and()->between('AlbumId', ':p1', ':p2')
            ->fetch();
        $this->assertCount(0, $fetch->all());
        $this->assertCount(10, $fetch->all(['p2' => 10]));
        $this->assertCount(0, $fetch->all(['p1' => 2]));
    }

    /**
     * @throws NotSupportedException
     */
    public function testOr()
    {
        $connection = $this->createConnection();
        $query = new SelectQuery($connection);
        /** @var ConditionInterface  $expression */
        $fetch = $query
            ->from('albums')->as('t1')
            ->where()->equal('AlbumId', 1)
            ->or()->in('AlbumId', [2,3])
            ->and()->expression(function (ConditionInterface $condition) {
                return $condition->in('AlbumId', [1,2])->or()->equal('AlbumId', 3);
            })
            ->fetch();
        $this->assertCount(3, $fetch->all());
    }

    /**
     * @throws NotSupportedException
     */
    public function testHashCondition()
    {
        $connection = $this->createConnection();
        $query = new SelectQuery($connection);
        /** @var ConditionInterface  $expression */
        $fetch = $query
            ->from('albums')->as('t1')
            ->where()->hashCondition(['AlbumId' => [1,':tt']])
            ->fetch();
        $this->assertCount(1, $fetch->all());
        $this->assertCount(2, $fetch->all(['tt' => 2]));
    }

    /**
     * @throws NotSupportedException
     */
    public function testLike()
    {
        $connection = $this->createConnection();
        $query = (new SelectQuery($connection))
            ->from('tracks')->as('t')
            ->where()->like('Name', 'rock')
            ->limit(5);
        foreach ($query as $row) {
            $this->assertStringContainsStringIgnoringCase('rock', $row['Name']);
        }
    }

    /**
     * @throws NotSupportedException
     */
    public function testLimit()
    {
        $connection = $this->createConnection();
        $command = (new SelectQuery($connection))
            ->from('tracks')->as('t')
            ->limit(5)->offset(10)
            ->orderBy(['TrackId' => SORT_ASC])
            ->fetch();
        $row = $command->one();
        $this->assertEquals(11, $row['TrackId']);
    }

    /**
     * @throws NotSupportedException
     */
    public function testHaving()
    {
        $connection = $this->createConnection();
        $count = (int)(new SelectQuery($connection))
            ->select('count(1)')
            ->from('genres')
            ->where()->like('Name', 'Rock')
            ->fetch()->scalar();
        $fetch = (new SelectQuery($connection))
            ->select(['t.GenreId', 'count(1) as cnt'])
            ->from('tracks t')->as('t')
            ->innerJoin('genres g')->on('g.GenreId=t.GenreId')
            ->groupBy(['t.GenreId', 'g.Name'])
            ->having()->like('g.Name', 'Rock')
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount($count, $rows);
    }
}
