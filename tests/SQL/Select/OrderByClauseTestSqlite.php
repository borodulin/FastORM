<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TestCase;

class OrderByClauseTestSqlite extends TestCase
{
    public function testExpression()
    {
        $fetch = (new SelectQuery($this->db))
            ->from('Track')->as('t')
            ->limit(5)
            ->orderBy(new Expression('TrackId asc'))
            ->fetch();
        $row = $fetch->one();
        $this->assertEquals(1, $row['TrackId']);
    }
}
