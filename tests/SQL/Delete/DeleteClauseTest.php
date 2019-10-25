<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Delete;

use FastOrm\SQL\Clause\DeleteQuery;
use FastOrm\Tests\TransactionTestCase;

class DeleteClauseTest extends TransactionTestCase
{
    public function testDelete()
    {
        $count = (new DeleteQuery($this->db))
            ->from('InvoiceLine')
            ->where()->equal('InvoiceLineId', 1)
            ->execute();
        $this->assertEquals($count, 1);
    }
}
