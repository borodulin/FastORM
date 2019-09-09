<?php

declare(strict_types=1);

namespace FastOrm\Tests\Domain\Entity;


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
     * @var string
     */
    private $company;
    /**
     * @var string
     */
    private $address;
    /**
     * @var string
     */
    private $city;
    /**
     * @var string
     */
    private $state;
    /**
     * @var string
     */
    private $country;
    /**
     * @var string
     */
    private $postalCode;
    /**
     * @var string
     */
    private $phone;
    /**
     * @var string
     */
    private $fax;
    /**
     * @var string
     */
    private $email;
    /**
     * @var int
     */
    private $supportRepId;
    /**
     * @var Employee
     */
    private $supportRep;
    /**
     * @var Invoice[]
     */
    private $invoices;

    /**
     * @return Employee
     */
    public function getSupportRep(): Employee
    {
        return $this->supportRep;
    }

    /**
     * @param Employee $supportRep
     */
    public function setSupportRep(Employee $supportRep): void
    {
        $this->supportRep = $supportRep;
    }

    /**
     * @return Invoice[]
     */
    public function getInvoices(): array
    {
        return $this->invoices;
    }

    /**
     * @param Invoice[] $invoices
     */
    public function setInvoices(array $invoices): void
    {
        $this->invoices = $invoices;
    }

}
