<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\PdoCommand;

use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\Tests\TestCase;

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
