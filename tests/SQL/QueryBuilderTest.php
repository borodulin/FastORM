<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Query;
use FastOrm\SQL\SearchCondition\SearchConditionInterface;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

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
        /** @var SearchConditionInterface  $expression */
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
        /** @var SearchConditionInterface  $expression */
        $command = $query
            ->from('albums')->alias('t1')
            ->where()->equal('AlbumId', 1)
            ->or()->equal('AlbumId', 2)
            ->prepare($connection);
        $fetch = $command->fetch();
        $this->assertCount(2, $fetch->all());
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
    public function testJoin()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('tracks')->alias('t')
            ->innerJoin('genres')->alias('g')->on('g.GenreID=t.GenreId')
            ->innerJoin('media_types')->alias('mt')->on('mt.MediaTypeId=t.MediaTypeId')
            ->limit(10)
            ->prepare($connection);
        $all = $command->fetch()->all();
        $this->assertCount(10, $all);
    }

    /**
     * @throws NotSupportedException
     */
    public function testSelect()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->select(['TrackId', 'Name'])->select('*')
            ->from('tracks')->alias('t')
            ->limit(10)
            ->prepare($connection);
        $all = $command->fetch()->all();
        $this->assertCount(10, $all);
    }
}
