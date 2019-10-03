<?php


namespace FastOrm\Tests\Domain\Repository;

use FastOrm\SQL\Clause\SelectQuery;

class CustomerRepository extends SelectQuery
{
    public function getInvoices()
    {
        return (clone $this)->where()->equal('', '');
    }
}
