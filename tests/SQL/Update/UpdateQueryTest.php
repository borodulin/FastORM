<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Update;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\PdoCommand\DbException;
use Borodulin\ORM\SQL\Clause\Operator\HashConditionOperator;
use Borodulin\ORM\SQL\Clause\UpdateQuery;
use Borodulin\ORM\SQL\Expression;
use Borodulin\ORM\Tests\TransactionTestCase;

class UpdateQueryTest extends TransactionTestCase
{
    public function testToString(): void
    {
        $update = (new UpdateQuery($this->db));
        $update->update(new Expression('Artist'));
        $this->assertEquals('UPDATE Artist SET ', (string) $update);
    }

    /**
     * @throws DbException
     */
    public function testImmutable(): void
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

    public function testBuildError(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new UpdateQuery($this->db))->build(new HashConditionOperator([]));
    }
}
