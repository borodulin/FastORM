<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\SearchCondition\ConditionInterface;
use FastOrm\Tests\TestCase;

class OrmQueryTest extends TestCase
{
    public function testSelect()
    {
        $query = new SelectQuery($this->connection);
        /** @var ConditionInterface  $expression */
        $fetch = $query
            ->select(['AlbumId', 'Title'])->distinct()
            ->from('Album')->as('t1')
            ->where()->hashCondition(['AlbumId' => [1,2]])
            ->fetch();
        $all = $fetch->indexBy('AlbumId')->all();
        $this->assertIsArray($all);
    }
}
