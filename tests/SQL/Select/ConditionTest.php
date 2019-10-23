<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TestCase;

class ConditionTest extends TestCase
{
    /**
     */
    public function testExists()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Album a')
            ->where()->exists(
                (new SelectQuery($this->connection))
                ->from('Artist t')
                ->where()->compareColumns('t.ArtistId', '=', 'a.ArtistId')
                ->and()->like('Name', 'Kiss')
            )
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(2, $rows);
    }

    /**
     */
    public function testCompare()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Album a')
            ->where()->compare('AlbumId', '>', 10)
            ->and()->not()->compare('AlbumId', '>', new Expression(':p12', ['p12' => 11]))
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(1, $rows);
    }

    /**
     */
    public function testBetweenColumns()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Employee e')
            ->where()->betweenColumns('2000-01-01', 'BirthDate', 'HireDate')
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(8, $rows);
    }

    /**
     */
    public function testFilterHashCondition()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Employee e')
            ->where()->filterHashCondition([
                'State' => null,
            ])
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(8, $rows);
    }

    /**
     */
    public function testEqual()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Album a')
            ->where()->equal('AlbumId', new Expression('(:p12)', ['p12' => 1]))
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(1, $rows);
    }

    /**
     */
    public function testLike()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Album a')
            ->where()->like('Title', new Expression(':p12', ['p12' => '%rock%']))
            ->and()->like('Title', 'rock')
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(7, $rows);
    }
}
