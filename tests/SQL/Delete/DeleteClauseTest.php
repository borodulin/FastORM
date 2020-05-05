<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Delete;

use Borodulin\ORM\SQL\Clause\DeleteQuery;
use Borodulin\ORM\Tests\TransactionTestCase;

class DeleteClauseTest extends TransactionTestCase
{
    public function testDelete(): void
    {
        $count = (new DeleteQuery($this->db))
            ->from('InvoiceLine')
            ->where()->equal('InvoiceLineId', 1)
            ->execute();
        $this->assertEquals($count, 1);
    }
}
