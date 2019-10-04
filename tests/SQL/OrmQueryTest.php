<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\SearchCondition\ConditionInterface;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class OrmQueryTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     */
    public function testSelect()
    {
        $connection = $this->createConnection();
        $query = new SelectQuery($connection);
        /** @var ConditionInterface  $expression */
        $fetch = $query
            ->select(['AlbumId', 'Title'])->distinct()
            ->from('albums')->as('t1')
            ->where()->hashCondition(['AlbumId' => [1,2]])
            ->fetch();
        $all = $fetch->indexBy('AlbumId')->all();
        $this->assertIsArray($all);
    }
}
