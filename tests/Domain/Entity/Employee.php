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
     * @var string
     */
    private $title;
    /**
     * @var int
     */
    private $reportsTo;
    /**
     * @var string
     */
    private $birthDate;
    /**
     * @var string
     */
    private $hireDate;
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
     * @var Customer[]
     */
    private $customers;
    /**
     * @var Employee
     */
    private $reportsToEmployee;

    /**
     * @return Customer[]
     */
    public function getCustomers(): array
    {
        return $this->customers;
    }

    /**
     * @param Customer[] $customers
     */
    public function setCustomers(array $customers): void
    {
        $this->customers = $customers;
    }

    /**
     * @return Employee
     */
    public function getReportsToEmployee(): Employee
    {
        return $this->reportsToEmployee;
    }

    /**
     * @param Employee $reportsToEmployee
     */
    public function setReportsToEmployee(Employee $reportsToEmployee): void
    {
        $this->reportsToEmployee = $reportsToEmployee;
    }
}
