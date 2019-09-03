<?php

namespace FastOrm\Tests\SQL;

use FastOrm\Connection;
use FastOrm\NotSupportedException;
use FastOrm\SQL\Query;
use FastOrm\SQL\SearchCondition\SearchConditionInterface;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
    /**
     * @throws NotSupportedException
     */
    private function createConnection()
    {
        $db = __DIR__ . '/../db/test.sqlite';
        return new Connection('sqlite:' . $db);
    }

    /**
     * @throws NotSupportedException
     */
    public function testQuery()
    {
        $connection = $this->createConnection();
        $query = new Query();
        /** @var SearchConditionInterface  $expression */
        $command = $query
            ->select('c1')->distinct()
            ->from('table1')->alias('t1')
            ->where()
//            ->expression('1=:p1', [':p1' => 1])
            ->between('c1', ':p1', ':p2')
            ->orderBy('c1')
            ->prepare($connection);
        $fetch = $command->fetch();
        $all = $fetch->column();
        $this->assertSame([], $all);
        $fetch = $command->fetch(['p1' => 1, 'p2' => 1]);
        $all = $fetch->column();
        $this->assertSame(['1'], $all);
    }
}
