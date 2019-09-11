<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Query;
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
        $command = (new Query())
            ->select([
                'id' => 'TrackId',
            ])
            ->from('tracks t')
            ->limit(10)
            ->prepare($connection);
        $rows = $command->fetch()->column();
        $this->assertCount(10, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testMap()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->select([
                'id' => 'TrackId',
                'TrackId'
            ])
            ->from('tracks t')
            ->orderBy('TrackId desc')
            ->limit(10)
            ->prepare($connection);
        $rows = $command->fetch()->map();
        $flip = array_flip($rows);
        $this->assertTrue($rows == $flip);
    }

    /**
     * @throws NotSupportedException
     */
    public function testExists()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->select('1')
            ->prepare($connection);
        $exists = $command->fetch()->exists();
        $this->assertEquals($exists, true);
        $command = (new Query())
            ->select('0')
            ->prepare($connection);
        $exists = $command->fetch()->exists();
        $this->assertEquals($exists, false);
    }
}
