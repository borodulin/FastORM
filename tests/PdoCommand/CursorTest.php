<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TestCase;

class CursorTest extends TestCase
{
    public function testCursor()
    {
        $count = (new SelectQuery($this->connection))
            ->select(new Expression('count(*)'))
            ->from('Album')
            ->fetch()
            ->scalar();
        $cursor = (new SelectQuery($this->connection))
            ->from('Album')
            ->fetch()
            ->cursor();
        $array = iterator_to_array($cursor);
        $this->assertIsArray($array);
        $this->assertCount((int)$count, $array);
    }

    /**
     */
    public function testRewind()
    {
        $cursor = $cursor = (new SelectQuery($this->connection))
            ->from('Album')
            ->fetch()
            ->cursor();
        foreach ($cursor as $row) {
            break;
        }
        $this->expectException(NotSupportedException::class);
        $cursor->rewind();
    }

    public function testLimit()
    {
        $cursor = (new SelectQuery($this->connection))
            ->from('Album')
            ->fetch()
            ->cursor()
            ->setLimit(10);
        $array = iterator_to_array($cursor);
        $this->assertIsArray($array);
        $this->assertCount(10, $array);
    }
}
