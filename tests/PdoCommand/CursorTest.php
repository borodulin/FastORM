<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\NotSupportedException;
use FastOrm\PdoCommand\Fetch\Cursor;
use FastOrm\Tests\TestCase;

class CursorTest extends TestCase
{
    public function testCursor()
    {
        $countStatement = $this->connection->getPdo()
            ->query('select count(*) from Album');
        $count = $countStatement->fetchColumn();
        $countStatement->closeCursor();
        $selectStatement = $this->connection->getPdo()
            ->query('select * from Album');
        $cursor = new Cursor($selectStatement);
        $array = iterator_to_array($cursor);
        $this->assertIsArray($array);
        $this->assertCount((int)$count, $array);
    }

    /**
     * @throws NotSupportedException
     */
    public function testRewind()
    {
        $statement = $this->connection->getPdo()->query('select * from Album');
        $cursor = new Cursor($statement);
        foreach ($cursor as $row) {
            break;
        }
        $this->expectException(NotSupportedException::class);
        $cursor->rewind();
    }
}
