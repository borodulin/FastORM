<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\PdoCommand\Fetch\BatchCursor;
use FastOrm\PdoCommand\Fetch\CursorFactoryInterface;
use FastOrm\PdoCommand\Fetch\CursorInterface;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestCase;
use PDO;
use PDOStatement;

class CursorFactoryTest extends TestCase implements CursorFactoryInterface
{
    public function testIterator()
    {
        $query = new SelectQuery($this->connection);
        $query->from('Album')->setCursorFactory($this);
        $this->assertCount(100, iterator_to_array($query));
    }

    public function create(PDOStatement $statement, int $fetchStyle = PDO::FETCH_ASSOC): CursorInterface
    {
        return (new BatchCursor($statement))->setLimit(100);
    }
}
