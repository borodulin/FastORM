<?php

namespace FastOrm\Tests\SQL;

use FastOrm\ConnectionFactory;
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
        $factory = new ConnectionFactory();
        $db = __DIR__ . '/../db/test.db';
        return $factory('sqlite:' . $db);
    }

    /**
     * @throws NotSupportedException
     */
    public function testQuery()
    {
        $connection = $this->createConnection();
        $query = new Query();
        $command = $query->from('table')
            ->alias('t')
            ->where()->not()->in('col1', [1,2,3])
            ->orderBy('1')
            ->prepare($connection);
        $command->fetch();
    }
}
