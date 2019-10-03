<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\PdoCommand\Fetch\Cursor;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class CursorTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws \FastOrm\NotSupportedException
     */
    public function testCursor()
    {
        $db = $this->createConnection();
        $countStatement = $db->getPdo()->query('select count(*) from albums');
        $count = $countStatement->fetchColumn();
        $countStatement->closeCursor();
        $selectStatement = $db->getPdo()->query('select * from albums');
        $cursor = new Cursor($selectStatement);
        $array = iterator_to_array($cursor);
        $this->assertIsArray($array);
        $this->assertCount((int)$count, $array);
    }
}
