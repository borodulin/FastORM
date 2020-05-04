<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestCase;

class BatchCursorTest extends TestCase
{
    public function testBatch(): void
    {
        $cursor = (new SelectQuery($this->db))
            ->from('Album')
            ->fetch()
            ->batchCursor();

        foreach ($cursor as $array) {
            $this->assertIsArray($array);
            $this->assertCount(25, $array);
            break;
        }
    }
}
