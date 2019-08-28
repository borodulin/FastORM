<?php


namespace FastOrm\Tests\SQL;


use FastOrm\QueryBuilder;
use FastOrm\SQL\Query;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
    public function testQuery()
    {
        $query = new Query();
        $query->from('table')
            ->alias('t')
            ->prepare();

    }
}
