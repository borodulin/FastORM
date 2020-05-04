<?php

declare(strict_types=1);

namespace FastOrm\Tests\Domain\Entity;

class Employee
{
    /**
     * @var int
     */
    private $employeeId;
    /**
     * @var string
     */
    private $lastName;
    /**
     * @var string
     */
    private $firstName;
    /**
     * @var string|null
     */
    private $title;
    /**
     * @var int|null
     */
    private $reportsTo;
    /**
     * @var string|null
     */
    private $birthDate;
    /**
     * @var string|null
     */
    private $hireDate;
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
     * @var Customer[]|null
     */
    private $customers;
    /**
     * @var Employee|null
     */
    private $reportsToEmployee;

    public function getEmployeeId(): int
    {
        return $this->employeeId;
    }

    public function setEmployeeId(int $employeeId): self
    {
        $this->employeeId = $employeeId;

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

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getReportsTo(): ?int
    {
        return $this->reportsTo;
    }

    public function setReportsTo(?int $reportsTo): self
    {
        $this->reportsTo = $reportsTo;

        return $this;
    }

    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    public function setBirthDate(?string $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getHireDate(): ?string
    {
        return $this->hireDate;
    }

    public function setHireDate(?string $hireDate): self
    {
        $this->hireDate = $hireDate;

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

    /**
     * @return Customer[]|null
     */
    public function getCustomers(): ?array
    {
        return $this->customers;
    }

    /**
     * @param Customer[]|null $customers
     */
    public function setCustomers(?array $customers): self
    {
        $this->customers = $customers;

        return $this;
    }

    public function getReportsToEmployee(): ?self
    {
        return $this->reportsToEmployee;
    }

    public function setReportsToEmployee(?self $reportsToEmployee): self
    {
        $this->reportsToEmployee = $reportsToEmployee;

        return $this;
    }
}
