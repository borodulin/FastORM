<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TestCase;


class InOperatorTest extends TestCase
{
    public function testEmpty()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Employee e')
            ->where()->in('EmployeeId', [])
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(0, $rows);
    }

    public function testArray()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Employee e')
            ->where()->in('EmployeeId', [1,2])
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(2, $rows);
    }

    public function testExpression()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Employee e')
            ->where()->in('EmployeeId', new Expression('(:p1,:p2)', ['p1' => 1, 'p2' => 2]))
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(2, $rows);

        $fetch = (new SelectQuery($this->connection))
            ->from('Employee e')
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

    public function testQuery()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Employee e')
            ->where()->in('EmployeeId', (new SelectQuery($this->connection))->select(new Expression('1')))
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(1, $rows);
    }

    public function testValue()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Employee e')
            ->where()->in('EmployeeId', 1)
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(1, $rows);
    }

    public function testObject()
    {
        $fetch = (new SelectQuery($this->connection))
            ->from('Employee e')
            ->where()->in('EmployeeId', (object)[])
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(0, $rows);
    }
}
