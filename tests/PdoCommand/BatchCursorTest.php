<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\NotSupportedException;
use FastOrm\PdoCommand\Fetch\BatchCursor;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class BatchCursorTest extends TestCase
{
    use TestConnectionTrait;
    /**
     * @var int
     */
    private $count;

    /**
     * @throws NotSupportedException
     */
    public function testLimit()
    {
        $db = $this->createConnection();
        $selectStatement = $db->getPdo()->query('select * from albums');
        $cursor = new BatchCursor($selectStatement);
        $cursor->setLimit(10);
        $array = iterator_to_array($cursor);
        $this->assertIsArray($array);
        $this->assertCount(10, $array);
    }

    /**
     * @throws NotSupportedException
     */
    public function testBatch()
    {
        $db = $this->createConnection();
        $countStatement = $db->getPdo()->query('select count(*) from albums');
        $count = (int)$countStatement->fetchColumn();
        $countStatement->closeCursor();

        $selectStatement = $db->getPdo()->query('select * from albums');
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

    /**
     * @throws NotSupportedException
     */
    public function testRowHandler()
    {
        $db = $this->createConnection();
        $countStatement = $db->getPdo()->query('select count(*) from albums');
        $count = (int)$countStatement->fetchColumn();
        $countStatement->closeCursor();

        $selectStatement = $db->getPdo()->query('select * from albums');
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
