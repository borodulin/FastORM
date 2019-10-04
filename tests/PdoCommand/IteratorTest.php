<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\NotSupportedException;
use FastOrm\PdoCommand\Fetch\BatchCursor;
use FastOrm\PdoCommand\Fetch\CursorInterface;
use FastOrm\PdoCommand\Fetch\IteratorFactoryInterface;
use FastOrm\PdoCommand\StatementInterface;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class IteratorTest extends TestCase implements IteratorFactoryInterface
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     */
    public function testIterator()
    {
        $db = $this->createConnection();
        $query = new SelectQuery($db);
        $query->from('albums')->setIteratorFactory($this);
        $this->assertCount(100, iterator_to_array($query));
    }

    public function create(StatementInterface $statement): CursorInterface
    {
        return (new BatchCursor($statement->execute()))->setLimit(100);
    }
}
