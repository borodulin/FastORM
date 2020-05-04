<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TestCase;

class CursorTest extends TestCase
{
    public function testCursor(): void
    {
        $count = (new SelectQuery($this->db))
            ->select(new Expression('count(*)'))
            ->from('Album')
            ->fetch()
            ->scalar();
        $cursor = (new SelectQuery($this->db))
            ->from('Album')
            ->fetch()
            ->cursor();
        $array = iterator_to_array($cursor);
        $this->assertIsArray($array);
        $this->assertCount((int) $count, $array);
    }

    public function testLimit(): void
    {
        $cursor = (new SelectQuery($this->db))
            ->from('Album')
            ->fetch()
            ->cursor([], 10)
        ;
        $array = iterator_to_array($cursor);
        $this->assertIsArray($array);
        $this->assertCount(10, $array);
    }
}
