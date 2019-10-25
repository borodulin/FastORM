<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Delete;

use FastOrm\SQL\Clause\DeleteQuery;
use FastOrm\Tests\TestCase;

class DeleteClauseTest extends TestCase
{
    public function testDelete()
    {
        $tran = $this->connection->beginTransaction();
        $count = (new DeleteQuery($this->connection))
            ->from('InvoiceLine')
            ->where()->equal('InvoiceLineId', 1)
            ->execute();
        $this->assertEquals($count, 1);
        $tran->rollBack();
    }
}
