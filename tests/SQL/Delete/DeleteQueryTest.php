<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Delete;

use Borodulin\ORM\InvalidArgumentException;
use Borodulin\ORM\SQL\Clause\DeleteQuery;
use Borodulin\ORM\SQL\Clause\Operator\HashConditionOperator;
use Borodulin\ORM\SQL\Expression;
use Borodulin\ORM\Tests\TransactionTestCase;

class DeleteQueryTest extends TransactionTestCase
{
    public function testToString(): void
    {
        $delete = new DeleteQuery($this->db);
        $delete->from(new Expression('Album'));
        $this->assertEquals('DELETE FROM Album', (string) $delete);
    }

    public function testImmutable(): void
    {
        $delete1 = (new DeleteQuery($this->db))->from('InvoiceLine')
            ->where()->equal('InvoiceLineId', 1);
        $delete2 = (clone $delete1)->and()->equal('InvoiceLineId', 2);
        $cnt1 = $delete1->execute();
        $cnt2 = $delete2->execute();
        $this->assertEquals(1, $cnt1);
        $this->assertEquals(0, $cnt2);
    }

    public function testBuildError(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new DeleteQuery($this->db))->build(new HashConditionOperator([]));
    }
}
