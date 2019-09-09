<?php

declare(strict_types=1);

namespace FastOrm\Tests\Domain\Entity;

class InvoiceItem
{
    private $invoiceLineId;
    private $invoiceId;
    private $trackId;
    private $unitPrice;
    private $quantity;
    /**
     * @var Invoice
     */
    private $invoice;
    /**
     * @var Track
     */
    private $track;
}
