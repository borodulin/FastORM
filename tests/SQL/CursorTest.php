<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;


class CursorTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @covers \FastOrm\PdoCommand\Fetch\Cursor
     * @throws NotSupportedException
     */
    public function testCursor()
    {
        $connection = $this->createConnection();
        $query = (new SelectQuery($connection));
        $query->from('albums')->alias('t1');
        $count = (clone $query)->select('count(1)')->fetch()->scalar();
        $rows = [];
        foreach ($query as $row) {
            $rows[] = $row;
        }
        $this->assertEquals($count, count($rows));
    }
}
