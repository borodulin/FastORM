<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Query;
use FastOrm\SQL\SearchCondition\SearchConditionInterface;
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
        $query = new Query();
        /** @var SearchConditionInterface  $expression */
        $command = $query
            ->select(['AlbumId', 'Title'])->distinct()
            ->from('albums')->alias('t1')
            ->where()->hashCondition(['AlbumId' => [1,2]])
            ->prepare($connection);
        $all = $command->fetch()->indexBy('AlbumId')->all();
        $this->assertIsArray($all);
    }
}
