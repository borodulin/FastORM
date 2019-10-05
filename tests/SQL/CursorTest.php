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
     * @throws NotSupportedException
     */
    public function testCursor()
    {
        $connection = $this->createConnection();
        $query = (new SelectQuery($connection))
            ->from('albums')->as('t1');
        $count = count($query);
        $rows = [];
        foreach ($query as $row) {
            $rows[] = $row;
        }
        $this->assertEquals($count, count($rows));
    }
}
