<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Insert;

use FastOrm\InvalidArgumentException;
use FastOrm\SQL\Clause\InsertQuery;
use FastOrm\SQL\Clause\Operator\HashConditionOperator;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TransactionTestCase;

class InsertQueryTest extends TransactionTestCase
{
    public function testToString()
    {
        $insert = new InsertQuery($this->db);
        $insert->into(new Expression('Album'));
        $this->assertEquals('INSERT INTO Album', (string)$insert);
    }

    public function testImmutable()
    {
        $insert1 = (new InsertQuery($this->db))->into('Album')
            ->columns(['Title', 'ArtistId', 'AlbumId']);
        $insert2 = (clone $insert1)->values(['Test2', 1, 10001]);
        $insert1->values(['Test1', 1, 10000]);
        $cnt1 = $insert1->execute();
        $cnt2 = $insert2->execute();
        $this->assertEquals(1, $cnt1);
        $this->assertEquals(1, $cnt2);
    }

    public function testBuildError()
    {
        $this->expectException(InvalidArgumentException::class);
        (new InsertQuery($this->db))->build(new HashConditionOperator([]));
    }
}