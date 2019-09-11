<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Query;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class ConditionTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     */
    public function testExists()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('albums a')
            ->where()->exists(
                (new Query())
                ->from('artists t')
                ->where()->expression('t.ArtistId=a.ArtistId')
                ->and()->like('Name', 'Kiss')
            )
            ->prepare($connection);
        $rows = $command->fetch()->all();
        $this->assertCount(2, $rows);
    }
}
