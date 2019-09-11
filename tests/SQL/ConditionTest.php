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

    /**
     * @throws NotSupportedException
     */
    public function testCompare()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('albums a')
            ->where()->compare('AlbumId', '>', 10)
            ->and()->not()->compare('AlbumId', '>', 11)
            ->prepare($connection);
        $rows = $command->fetch()->all();
        $this->assertCount(1, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testBetweenColumns()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('employees e')
            ->where()->betweenColumns('2000-01-01', 'BirthDate', 'HireDate')
            ->prepare($connection);
        $rows = $command->fetch()->all();
        $this->assertCount(8, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testFilterHashCondition()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('employees e')
            ->where()->filterHashCondition([
                'State' => null,
            ])
            ->prepare($connection);
        $rows = $command->fetch()->all();
        $this->assertCount(8, $rows);
    }
}
