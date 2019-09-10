<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Query;
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
        $query = (new Query())
            ->from('albums')->alias('t1');
        $commandCursor = $query->prepare($connection);
        $commandCount = $query->select('count(1)')->prepare($connection);
        $count = $commandCount->fetch()->scalar();
        $cursor = $commandCursor->fetch()->cursor();
        $rows = [];
        foreach ($cursor as $row) {
            $rows[] = $row;
        }
        $this->assertEquals($count, count($rows));
    }
}
