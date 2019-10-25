<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Update;

use FastOrm\InvalidArgumentException;
use FastOrm\PdoCommand\DbException;
use FastOrm\SQL\Clause\Operator\HashConditionOperator;
use FastOrm\SQL\Clause\UpdateQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TransactionTestCase;

class UpdateQueryTest extends TransactionTestCase
{
    public function testToString()
    {
        $update = (new UpdateQuery($this->db));
        $update->update(new Expression('Artist'));
        $this->assertEquals('UPDATE Artist SET ', (string)$update);
    }

    /**
     * @throws DbException
     */
    public function testImmutable()
    {
        $update1 = (new UpdateQuery($this->db));
        $update1->update('Artist')
            ->set(['Name' => 'Dummy'])
            ->where()->equal('ArtistId', 1);
        $update2 = clone $update1;
        $update2->where()->equal('ArtistId', 2);
        $count1 = $update1->count();
        $count2 = $update2->count();
        $this->assertEquals(1, $count1);
        $this->assertEquals(0, $count2);
    }

    public function testBuildError()
    {
        $this->expectException(InvalidArgumentException::class);
        (new UpdateQuery($this->db))->build(new HashConditionOperator([]));
    }
}
