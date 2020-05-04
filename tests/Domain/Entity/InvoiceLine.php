<?php

declare(strict_types=1);

namespace FastOrm\Tests\Domain\Entity;

class InvoiceLine
{
    /**
     * @var int
     */
    private $invoiceLineId;
    /**
     * @var int
     */
    private $invoiceId;
    /**
     * @var int
     */
    private $trackId;
    /**
     * @var string
     */
    private $unitPrice;
    /**
     * @var int
     */
    private $quantity;
    /**
     * @var Invoice
     */
    private $invoice;
    /**
     * @var Track
     */
    private $track;

    public function getInvoiceLineId(): int
    {
        return $this->invoiceLineId;
    }

    public function setInvoiceLineId(int $invoiceLineId): self
    {
        $this->invoiceLineId = $invoiceLineId;

        return $this;
    }

    public function getInvoiceId(): int
    {
        return $this->invoiceId;
    }

    public function setInvoiceId(int $invoiceId): self
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }

    public function getTrackId(): int
    {
        return $this->trackId;
    }

    public function setTrackId(int $trackId): self
    {
        $this->trackId = $trackId;

        return $this;
    }

    public function getUnitPrice(): string
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(string $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(Invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getTrack(): Track
    {
        return $this->track;
    }

    public function setTrack(Track $track): self
    {
        $this->track = $track;

        return $this;
    }
}
