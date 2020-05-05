<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Select;

use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\SQL\Expression;
use Borodulin\ORM\Tests\TestCase;

class InOperatorTest extends TestCase
{
    public function testEmpty(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->from('Employee e')
            ->where()->in('EmployeeId', [])
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(0, $rows);
    }

    public function testArray(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->from('Employee e')
            ->where()->in('EmployeeId', [1, 2])
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(2, $rows);
    }

    public function testExpression(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->from('Employee e')
            ->where()->in('EmployeeId', new Expression('(:p1,:p2)', ['p1' => 1, 'p2' => 2]))
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(2, $rows);

        $fetch = (new SelectQuery($this->db))
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

    public function testQuery(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->from('Employee e')
            ->where()->in('EmployeeId', (new SelectQuery($this->db))->select(new Expression('1')))
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(1, $rows);
    }

    public function testValue(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->from('Employee e')
            ->where()->in('EmployeeId', 1)
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(1, $rows);
    }

    public function testObject(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->from('Employee e')
            ->where()->in('EmployeeId', (object) [])
            ->fetch();
        $rows = $fetch->all();
        $this->assertCount(0, $rows);
    }
}
