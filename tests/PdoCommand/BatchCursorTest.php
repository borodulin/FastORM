<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\PdoCommand\Fetch\BatchCursor;
use FastOrm\Tests\TestCase;

class BatchCursorTest extends TestCase
{
    /**
     * @var int
     */
    private $count;

    public function testLimit()
    {
        $selectStatement = $this->connection->getPdo()
            ->query('select * from Album');
        $cursor = new BatchCursor($selectStatement);
        $cursor->setLimit(10);
        $array = iterator_to_array($cursor);
        $this->assertIsArray($array);
        $this->assertCount(10, $array);
    }

    public function testBatch()
    {
        $countStatement = $this->connection->getPdo()
            ->query('select count(*) from Album');
        $count = (int)$countStatement->fetchColumn();
        $countStatement->closeCursor();

        $selectStatement = $this->connection->getPdo()->query('select * from Album');
        $cursor = new BatchCursor($selectStatement);
        $this->count = 0;
        $cursor->setBatchSize(10)->setBatchHandler([$this, 'handleBatch']);
        $array = iterator_to_array($cursor);
        $this->assertIsArray($array);
        $this->assertCount($count, $array);
        $this->assertEquals($this->count, $count);
    }

    public function handleBatch($rows)
    {
        $this->count += count($rows);
    }

    public function testRowHandler()
    {
        $countStatement = $this->connection->getPdo()
            ->query('select count(*) from Album');
        $count = (int)$countStatement->fetchColumn();
        $countStatement->closeCursor();

        $selectStatement = $this->connection->getPdo()
            ->query('select * from Album');
        $cursor = new BatchCursor($selectStatement);
        $this->count = 0;
        $cursor->setBatchSize(10)->setRowHandler([$this, 'handleRow']);
        $array = iterator_to_array($cursor);
        $this->assertIsArray($array);
        $this->assertCount($count, $array);
        $this->assertEquals($this->count, $count);
    }

    public function handleRow()
    {
        $this->count++;
    }
}
