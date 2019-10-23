<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\SQL\QueryBuilder;
use FastOrm\SQL\SearchCondition\ConditionInterface;
use FastOrm\SQL\SearchCondition\Operator\CompareColumnsOperator;
use FastOrm\Tests\TestCase;

/**
 * Class QueryBuilderTest
 * @package FastOrm\Tests\SQL
 */
class QueryBuilderTest extends TestCase
{
    public function testParamBinding()
    {
        $query = (new QueryBuilder($this->connection))->select();
        /** @var ConditionInterface  $expression */
        $fetch = $query
            ->from('Album')->as('t1')
            ->where()
            ->expression('1=:p1', [':p1' => 1])
            ->and()->between('AlbumId', ':p1', ':p2')
            ->fetch();
        $this->assertCount(0, $fetch->all());
        $this->assertCount(10, $fetch->all(['p2' => 10]));
        $this->assertCount(0, $fetch->all(['p1' => 2]));
    }

    public function testOr()
    {
        $query = new SelectQuery($this->connection);
        /** @var ConditionInterface  $expression */
        $fetch = $query
            ->from('Album')->as('t1')
            ->where()->equal('AlbumId', 1)
            ->or()->in('AlbumId', [2,3])
            ->and()->expression(function (ConditionInterface $condition) {
                return $condition->in('AlbumId', [1,2])->or()->equal('AlbumId', 3);
            })
            ->fetch();
        $this->assertCount(3, $fetch->all());
    }

    public function testHashCondition()
    {
        $query = new SelectQuery($this->connection);
        /** @var ConditionInterface  $expression */
        $fetch = $query
            ->from('Album')->as('t1')
            ->where()->hashCondition(['AlbumId' => [1,':tt']])
            ->fetch();
        $this->assertCount(1, $fetch->all());
        $this->assertCount(2, $fetch->all(['tt' => 2]));
    }

    public function testLike()
    {
        $query = (new SelectQuery($this->connection))
            ->from('Track')->as('t')
            ->where()->like('Name', 'rock')
            ->limit(5);
        foreach ($query as $row) {
            $this->assertStringContainsStringIgnoringCase('rock', $row['Name']);
        }
    }

    public function testLimit()
    {
        $command = (new SelectQuery($this->connection))
            ->from('Track')->as('t')
            ->limit(5)->offset(10)
            ->orderBy(['TrackId' => SORT_ASC])
            ->fetch();
        $row = $command->one();
        $this->assertEquals(11, $row['TrackId']);
    }

    public function testHaving()
    {
        $count = (int)(new SelectQuery($this->connection))
            ->select('count(1)')
            ->from('Genre')
            ->where()->like('Name', 'Rock')
            ->fetch()->scalar();
        $fetch = (new SelectQuery($this->connection))
            ->select(['t.GenreId', new Expression('count(1) as cnt')])
            ->from('Track t')->as('t')
            ->innerJoin('Genre g')->on(new CompareColumnsOperator('g.GenreId', '=', 't.GenreId'))
            ->groupBy(['t.GenreId', 'g.Name'])
            ->having()->like('g.Name', 'Rock')
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount($count, $rows);
    }
}
