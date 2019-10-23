<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Select;

use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestCase;


class CursorTest extends TestCase
{
    /**
     */
    public function testCursor()
    {
        $query = (new SelectQuery($this->connection))
            ->from('Album')->as('t1');
        $count = count($query);
        $rows = [];
        foreach ($query as $row) {
            $rows[] = $row;
        }
        $this->assertEquals($count, count($rows));
    }
}
