<?php

declare(strict_types=1);

namespace FastOrm\Tests\Domain\Entity;


class Invoice
{
    private $invoiceId;
    private $customerId;
    private $invoiceDate;
    private $billingAddress;
    private $billingCity;
    private $billingState;
    private $billingCountry;
    private $billingPostalCode;
    private $total;
    /**
     * @var Customer
     */
    private $customer;
    /**
     * @var InvoiceItem[]
     */
    private $items;
}
