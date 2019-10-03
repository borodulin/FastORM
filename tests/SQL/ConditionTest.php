<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
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
        $fetch = (new SelectQuery($connection))
            ->from('albums a')
            ->where()->exists(
                (new SelectQuery($connection))
                ->from('artists t')
                ->where()->expression('t.ArtistId=a.ArtistId')
                ->and()->like('Name', 'Kiss')
            )
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(2, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testCompare()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('albums a')
            ->where()->compare('AlbumId', '>', 10)
            ->and()->not()->compare('AlbumId', '>', new Expression(':p12', ['p12' => 11]))
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(1, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testBetweenColumns()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('employees e')
            ->where()->betweenColumns('2000-01-01', 'BirthDate', 'HireDate')
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(8, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testFilterHashCondition()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('employees e')
            ->where()->filterHashCondition([
                'State' => null,
            ])
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(8, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testEqual()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('albums a')
            ->where()->equal('AlbumId', new Expression('(:p12)', ['p12' => 1]))
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(1, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testLike()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('albums a')
            ->where()->like('Title', new Expression(':p12', ['p12' => '%rock%']))
            ->and()->like('Title', 'rock')
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(7, $rows);
    }
}
