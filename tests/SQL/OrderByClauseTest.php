<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;


use FastOrm\NotSupportedException;
use FastOrm\SQL\Expression;
use FastOrm\SQL\Query;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class OrderByClauseTest extends TestCase
{
    use TestConnectionTrait;

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
    public function testArray()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('tracks')->alias('t')
            ->limit(5)
            ->orderBy(['TrackId', 'Name' => SORT_DESC])
            ->prepare($connection);
        $row = $command->fetch()->one();
        $this->assertEquals(1, $row['TrackId']);
    }

    /**
     * @throws NotSupportedException
     */
    public function testString()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('tracks')->alias('t')
            ->limit(5)
            ->orderBy('TrackId asc, Name desc')
            ->prepare($connection);
        $row = $command->fetch()->one();
        $this->assertEquals(1, $row['TrackId']);
    }

    /**
     * @throws NotSupportedException
     */
    public function testExpression()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('tracks')->alias('t')
            ->limit(5)
            ->orderBy(new Expression('TrackId asc'))
            ->prepare($connection);
        $row = $command->fetch()->one();
        $this->assertEquals(1, $row['TrackId']);
    }
}
