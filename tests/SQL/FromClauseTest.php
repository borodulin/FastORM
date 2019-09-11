<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Query;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class FromClauseTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     */
    public function testEmptyFrom()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->select('1')
            ->prepare($connection);
        $one = $command->fetch()->scalar();
        $this->assertEquals(1, $one);
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
    public function testSubQuery()
    {
        $connection = $this->createConnection();
        $query = (new Query())
            ->from('tracks')->alias('t')
            ->limit(10);
        $command = (new Query())
            ->from($query)->alias('s')
            ->prepare($connection);
        $all = $command->fetch()->all();
        $this->assertCount(10, $all);
    }

    /**
     * @throws NotSupportedException
     */
    public function testFromAlias()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('tracks t')
            ->limit(10)
            ->prepare($connection);
        $all = $command->fetch()->all();
        $this->assertCount(10, $all);
    }
}