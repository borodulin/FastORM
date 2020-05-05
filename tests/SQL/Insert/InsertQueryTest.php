<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Insert;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\Clause\InsertQuery;
use Borodulin\ORM\SQL\Clause\Operator\HashConditionOperator;
use Borodulin\ORM\SQL\Expression;
use Borodulin\ORM\Tests\TransactionTestCase;

class InsertQueryTest extends TransactionTestCase
{
    public function testToString(): void
    {
        $insert = new InsertQuery($this->db);
        $insert->into(new Expression('Album'));
        $this->assertEquals('INSERT INTO Album', (string) $insert);
    }

    public function testImmutable(): void
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

    public function testBuildError(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new InsertQuery($this->db))->build(new HashConditionOperator([]));
    }
}
