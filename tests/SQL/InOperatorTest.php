<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class InOperatorTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     */
    public function testEmpty()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('employees e')
            ->where()->in('EmployeeId', [])
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(0, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testArray()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('employees e')
            ->where()->in('EmployeeId', [1,2])
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(2, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testExpression()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('employees e')
            ->where()->in('EmployeeId', new Expression('(:p1,:p2)', ['p1' => 1, 'p2' => 2]))
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(2, $rows);

        $fetch = (new SelectQuery($connection))
            ->from('employees e')
            ->where()->in(
                'EmployeeId',
                [
                    new Expression(':p1', ['p1' => 1]),
                    new Expression(':p2', ['p2' => 2]),
                ]
            )
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(2, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testQuery()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('employees e')
            ->where()->in('EmployeeId', (new SelectQuery($connection))->select('1'))
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(1, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testValue()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('employees e')
            ->where()->in('EmployeeId', 1)
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(1, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testObject()
    {
        $connection = $this->createConnection();
        $fetch = (new SelectQuery($connection))
            ->from('employees e')
            ->where()->in('EmployeeId', (object)[])
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(0, $rows);
    }
}
