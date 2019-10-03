<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class SelectClauseTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     */
    public function testSelect()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->select([
                'id' => 'TrackId',
                'Name as name1',
                'Name as name2',
                new Expression('5')
            ])->select('*')
            ->from('tracks')->alias('t')
            ->limit(10)
            ->fetch();
        $row = $fetch->one();
        $this->assertArrayHasKey('id', $row);
        $this->assertArrayHasKey('name1', $row);
        $this->assertArrayHasKey('name2', $row);
        $this->assertArrayHasKey('TrackId', $row);
        $this->assertArrayHasKey('5', $row);
    }

    /**
     * @throws NotSupportedException
     */
    public function testSelectQuery()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->select([
                'GenreName' => (new SelectQuery($connection))
                    ->select('Name')
                    ->from('genres g')
                    ->where()->expression('g.GenreId=t.GenreId'),
            ])->select('*')
            ->from('tracks t')
            ->limit(10)
            ->fetch();
        $row = $fetch->one();
        $this->assertArrayHasKey('GenreName', $row);
        $this->assertArrayHasKey('TrackId', $row);
    }

    /**
     * @throws NotSupportedException
     */
    public function testUnionAll()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->select([
                'TrackId as id',
                'Name'
            ])
            ->from('tracks t')
            ->limit(10)
            ->unionAll(
                (new SelectQuery($connection))
                ->select(['AlbumId', 'Title'])
                ->from('albums')
            )
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(10, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testUnion()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->select([
                'TrackId as id',
                'Name'
            ])
            ->from('tracks t')
            ->limit(10)
            ->union(
                (new SelectQuery($connection))
                ->select(['AlbumId', 'Title'])
                ->from('albums')
            )
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(10, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testDistinct()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->select('ArtistId as id')
            ->distinct()
            ->from('albums')
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(204, $rows);
    }
}
