<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Select;

use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\Tests\TestCase;

class CursorTest extends TestCase
{
    public function testCursor(): void
    {
        $query = (new SelectQuery($this->db))
            ->from('Album')->as('t1');
        $count = \count($query);
        $rows = [];
        foreach ($query as $row) {
            $rows[] = $row;
        }
        $this->assertEquals($count, \count($rows));
    }
}
