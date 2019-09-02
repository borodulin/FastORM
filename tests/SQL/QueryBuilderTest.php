<?php

namespace FastOrm\Tests\SQL;

use FastOrm\Connection;
use FastOrm\NotSupportedException;
use FastOrm\SQL\Query;
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
        $command = $query->from('table1')
            ->select('c1')
//            ->alias('t')
            ->where()
            //->not()->in('c1', [1,2,3])->or()
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
