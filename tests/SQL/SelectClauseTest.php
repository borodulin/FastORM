<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Query;
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
        $command = (new Query())
            ->select([
                'id' => 'TrackId',
                'Name as name1',
                'Name as name2',
            ])->select('*')
            ->from('tracks')->alias('t')
            ->limit(10)
            ->prepare($connection);
        $row = $command->fetch()->one();
        $this->assertArrayHasKey('id', $row);
        $this->assertArrayHasKey('name1', $row);
        $this->assertArrayHasKey('name2', $row);
        $this->assertArrayHasKey('TrackId', $row);
    }

    /**
     * @throws NotSupportedException
     */
    public function testSelectQuery()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->select([
                'GenreName' => (new Query())
                    ->select('Name')
                    ->from('genres g')
                    ->where()->expression('g.GenreId=t.GenreId')
                    ->limit(1),
            ])->select('*')
            ->from('tracks t')
            ->limit(10)
            ->prepare($connection);
        $row = $command->fetch()->one();
        $this->assertArrayHasKey('GenreName', $row);
        $this->assertArrayHasKey('TrackId', $row);
    }
}
