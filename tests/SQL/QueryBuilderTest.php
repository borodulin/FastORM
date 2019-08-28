<?php

namespace FastOrm\Tests\SQL;

use FastOrm\Connection;
use FastOrm\SQL\Query;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
    public function testQuery()
    {
        $connection = new Connection();
        $query = new Query();
        $command = $query->from('table')
            ->alias('t')
            ->prepare($connection);
    }
}
