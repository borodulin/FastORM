<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\Domain\Entity;

class Invoice
{
    /**
     * @var int
     */
    private $invoiceId;
    /**
     * @var int
     */
    private $customerId;
    /**
     * @var \DateTime
     */
    private $invoiceDate;
    /**
     * @var string|null
     */
    private $billingAddress;
    /**
     * @var string|null
     */
    private $billingCity;
    /**
     * @var string|null
     */
    private $billingState;
    /**
     * @var string|null
     */
    private $billingCountry;
    /**
     * @var string|null
     */
    private $billingPostalCode;
    /**
     * @var string
     */
    private $total;
    /**
     * @var Customer
     */
    private $customer;
    /**
     * @var InvoiceLine[]
     */
    private $items;

    public function getInvoiceId(): int
    {
        return $this->invoiceId;
    }

    public function setInvoiceId(int $invoiceId): self
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId): self
    {
        $this->customerId = $customerId;

        return $this;
    }

    public function getInvoiceDate(): \DateTime
    {
        return $this->invoiceDate;
    }

    public function setInvoiceDate(\DateTime $invoiceDate): self
    {
        $this->invoiceDate = $invoiceDate;

        return $this;
    }

    public function getBillingAddress(): ?string
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(?string $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getBillingCity(): ?string
    {
        return $this->billingCity;
    }

    public function setBillingCity(?string $billingCity): self
    {
        $this->billingCity = $billingCity;

        return $this;
    }

    public function getBillingState(): ?string
    {
        return $this->billingState;
    }

    public function setBillingState(?string $billingState): self
    {
        $this->billingState = $billingState;

        return $this;
    }

    public function getBillingCountry(): ?string
    {
        return $this->billingCountry;
    }

    public function setBillingCountry(?string $billingCountry): self
    {
        $this->billingCountry = $billingCountry;

        return $this;
    }

    public function getBillingPostalCode(): ?string
    {
        return $this->billingPostalCode;
    }

    public function setBillingPostalCode(?string $billingPostalCode): self
    {
        $this->billingPostalCode = $billingPostalCode;

        return $this;
    }

    public function getTotal(): string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return InvoiceLine[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param InvoiceLine[] $items
     */
    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }
}
