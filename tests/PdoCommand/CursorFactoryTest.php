<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\NotSupportedException;
use FastOrm\PdoCommand\Fetch\BatchCursor;
use FastOrm\PdoCommand\Fetch\CursorFactoryInterface;
use FastOrm\PdoCommand\Fetch\CursorInterface;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestConnectionTrait;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class CursorFactoryTest extends TestCase implements CursorFactoryInterface
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     */
    public function testIterator()
    {
        $db = $this->createConnection();
        $query = new SelectQuery($db);
        $query->from('albums')->setCursorFactory($this);
        $this->assertCount(100, iterator_to_array($query));
    }

    public function create(PDOStatement $statement, int $fetchStyle = PDO::FETCH_ASSOC): CursorInterface
    {
        return (new BatchCursor($statement))->setLimit(100);
    }
}
