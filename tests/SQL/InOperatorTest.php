<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Expression;
use FastOrm\SQL\Query;
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
        $command = (new Query())
            ->from('employees e')
            ->where()->in('EmployeeId', [])
            ->prepare($connection);
        $rows = $command->fetch()->all();
        $this->assertCount(0, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testArray()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('employees e')
            ->where()->in('EmployeeId', [1,2])
            ->prepare($connection);
        $rows = $command->fetch()->all();
        $this->assertCount(2, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testExpression()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('employees e')
            ->where()->in('EmployeeId', new Expression('(:p1,:p2)', ['p1' => 1, 'p2' => 2]))
            ->prepare($connection);
        $rows = $command->fetch()->all();
        $this->assertCount(2, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testQuery()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('employees e')
            ->where()->in('EmployeeId', (new Query())->select('1'))
            ->prepare($connection);
        $rows = $command->fetch()->all();
        $this->assertCount(1, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testValue()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('employees e')
            ->where()->in('EmployeeId', 1)
            ->prepare($connection);
        $rows = $command->fetch()->all();
        $this->assertCount(1, $rows);
    }

    /**
     * @throws NotSupportedException
     */
    public function testObject()
    {
        $connection = $this->createConnection();
        $command = (new Query())
            ->from('employees e')
            ->where()->in('EmployeeId', (object)[])
            ->prepare($connection);
        $rows = $command->fetch()->all();
        $this->assertCount(0, $rows);
    }
}
