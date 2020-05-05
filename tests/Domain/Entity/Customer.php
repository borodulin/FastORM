<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\Domain\Entity;

class Customer
{
    /**
     * @var int
     */
    private $customerId;
    /**
     * @var string
     */
    private $firstName;
    /**
     * @var string
     */
    private $lastName;
    /**
     * @var string|null
     */
    private $company;
    /**
     * @var string|null
     */
    private $address;
    /**
     * @var string|null
     */
    private $city;
    /**
     * @var string|null
     */
    private $state;
    /**
     * @var string|null
     */
    private $country;
    /**
     * @var string|null
     */
    private $postalCode;
    /**
     * @var string|null
     */
    private $phone;
    /**
     * @var string|null
     */
    private $fax;
    /**
     * @var string|null
     */
    private $email;
    /**
     * @var int|null
     */
    private $supportRepId;
    /**
     * @var Employee|null
     */
    private $supportRep;
    /**
     * @var Invoice[]|null
     */
    private $invoices;

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId): self
    {
        $this->customerId = $customerId;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSupportRepId(): ?int
    {
        return $this->supportRepId;
    }

    public function setSupportRepId(?int $supportRepId): self
    {
        $this->supportRepId = $supportRepId;

        return $this;
    }

    public function getSupportRep(): ?Employee
    {
        return $this->supportRep;
    }

    public function setSupportRep(?Employee $supportRep): self
    {
        $this->supportRep = $supportRep;

        return $this;
    }

    /**
     * @return Invoice[]|null
     */
    public function getInvoices(): ?array
    {
        return $this->invoices;
    }

    /**
     * @param Invoice[]|null $invoices
     */
    public function setInvoices(?array $invoices): self
    {
        $this->invoices = $invoices;

        return $this;
    }
}
