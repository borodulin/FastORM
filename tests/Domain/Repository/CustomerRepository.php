<?php


namespace FastOrm\Tests\Domain\Repository;

use FastOrm\SQL\Query;
use FastOrm\SQL\QueryInterface;

class CustomerRepository
{
    public function query(): QueryInterface
    {
        return (new Query())->from('customers');
    }

    public function getInvoices()
    {

    }
}
