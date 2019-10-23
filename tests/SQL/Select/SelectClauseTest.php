<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TestCase;

class SelectClauseTest extends TestCase
{
    public function testString()
    {
        $query = (new SelectQuery($this->connection))
            ->select(new Expression('1'));
        $this->assertEquals('SELECT 1', (string)$query);
    }


    public function testSelect()
    {
        $fetch = (new SelectQuery($this->connection))
            ->select([
                'id' => 'TrackId',
                'Name as name1',
                'Name as name2',
                new Expression('5 as "5"')
            ])->select('t.*')
            ->from('Track')->as('t')
            ->limit(10)
            ->fetch();
        $row = $fetch->one();
        $this->assertArrayHasKey('id', $row);
        $this->assertArrayHasKey('name1', $row);
        $this->assertArrayHasKey('name2', $row);
        $this->assertArrayHasKey('TrackId', $row);
        $this->assertArrayHasKey('5', $row);
    }

    public function testSelectQuery()
    {
        $query = (new SelectQuery($this->connection))
            ->select([
                'GenreName' => (new SelectQuery($this->connection))
                    ->select('Name')
                    ->from('Genre g')
                    ->where()->compareColumns('g.GenreId', '=', 't.GenreId'),
            ])->select('t.*')
            ->from('Track t')
            ->limit(10);
        $fetch = $query->fetch();
        $row = $fetch->one();
        $this->assertArrayHasKey('GenreName', $row);
        $this->assertArrayHasKey('TrackId', $row);
    }

    public function testUnionAll()
    {
        $fetch = (new SelectQuery($this->connection))
            ->select([
                'TrackId as id',
                'Name'
            ])
            ->from('Track t')
            ->limit(10)
            ->unionAll(
                (new SelectQuery($this->connection))
                ->select(['AlbumId', 'Title'])
                ->from('Album')
            )
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(10, $rows);
    }

    public function testUnion()
    {
        $fetch = (new SelectQuery($this->connection))
            ->select([
                'TrackId as id',
                'Name'
            ])
            ->from('Track t')
            ->limit(10)
            ->union(
                (new SelectQuery($this->connection))
                ->select(['AlbumId', 'Title'])
                ->from('Album')
            )
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(10, $rows);
    }

    public function testDistinct()
    {
        $fetch = (new SelectQuery($this->connection))
            ->select('ArtistId as id')
            ->distinct()
            ->from('Album')
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(204, $rows);
    }
}
