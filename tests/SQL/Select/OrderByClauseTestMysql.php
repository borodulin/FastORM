<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Select;

use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\SQL\Expression;
use Borodulin\ORM\Tests\TestCase;

class OrderByClauseTestMysql extends TestCase
{
    public function testExpression(): void
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
