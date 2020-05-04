<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\SQL\Expression;
use FastOrm\SQL\QueryBuilder;
use FastOrm\Tests\TestCase;

class QueryBuilderTest extends TestCase
{
    public function testSelect(): void
    {
        $select = (new QueryBuilder($this->db))->select();
        $this->assertEquals('SELECT *', $select);
    }

    public function testUpdate(): void
    {
        $update = (new QueryBuilder($this->db))->update(new Expression('Artist'));
        $this->assertEquals('UPDATE Artist SET ', (string) $update);
    }

    public function testInsert(): void
    {
        $insert = (new QueryBuilder($this->db))->insertInto(new Expression('Artist'));
        $this->assertEquals('INSERT INTO Artist', (string) $insert);
    }

    public function testDelete(): void
    {
        $delete = (new QueryBuilder($this->db))->deleteFrom(new Expression('Artist'));
        $this->assertEquals('DELETE FROM Artist', (string) $delete);
    }
}
