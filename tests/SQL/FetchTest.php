<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class FetchTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     */
    public function testColumn()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->select([
                'id' => 'TrackId',
            ])
            ->from('tracks t')
            ->limit(10)
            ->fetch();
        $rows = $fetch->column();
        $this->assertCount(10, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testMap()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->select([
                'id' => 'TrackId',
                'TrackId'
            ])
            ->from('tracks t')
            ->orderBy('TrackId desc')
            ->limit(10)
            ->fetch();
        $rows = $fetch->map();
        $flip = array_flip($rows);
        $this->assertTrue($rows == $flip);
    }

    /**
     * @throws NotSupportedException
     */
    public function testExists()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->select('1')
            ->fetch();
        $exists = $fetch->exists();
        $this->assertEquals($exists, true);
        $fetch = (new SelectQuery($connection))
            ->select('0')
            ->fetch();
        $exists = $fetch->exists();
        $this->assertEquals($exists, false);
    }
}
