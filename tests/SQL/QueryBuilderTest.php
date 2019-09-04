<?php

namespace FastOrm\Tests\SQL;

use FastOrm\Connection;
use FastOrm\NotSupportedException;
use FastOrm\SQL\Query;
use FastOrm\SQL\SearchCondition\SearchConditionInterface;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
    /**
     * @throws NotSupportedException
     */
    private function createConnection()
    {
        $db = __DIR__ . '/../db/chinook.db';
        return new Connection('sqlite:' . $db);
    }

    /**
     * @throws NotSupportedException
     */
    public function testQuery()
    {
        $connection = $this->createConnection();
        $query = new Query();
        /** @var SearchConditionInterface  $expression */
        $command = $query
            ->select(['AlbumId', 'Title'])->distinct()
            ->from('albums')->alias('t1')
            ->where()
//            ->expression('1=:p1', [':p1' => 1])
            ->between('AlbumId', ':p1', ':p2')
            ->orderBy('AlbumId')
            ->prepare($connection);
        $fetch = $command->fetch();
        $all = $fetch->column();
        $this->assertSame([], $all);
        $fetch = $command->fetch(['p1' => 1, 'p2' => 1]);
        $all = $fetch->column();
        $this->assertSame(['1'], $all);
    }

    /**
     * @throws NotSupportedException
     */
    public function testHashCondition()
    {
        $connection = $this->createConnection();
        $query = new Query();
        /** @var SearchConditionInterface  $expression */
        $command = $query
            ->select(['AlbumId', 'Title'])->distinct()
            ->from('albums')->alias('t1')
            ->where()->hashCondition(['AlbumId' => [1,2]])
            ->prepare($connection);
        $fetch = $command->fetch();
        $all = $fetch->all();
        $this->assertCount(2, $all);
        $fetch = $command->fetch(['p1' => 1, 'p2' => 1]);
        $all = $fetch->all();
        $this->assertCount(1, $all);
    }
}
