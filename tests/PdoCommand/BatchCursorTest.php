<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\SQL\Expression;
use FastOrm\Tests\TestCase;

class BatchCursorTest extends TestCase
{
    /**
     * @var int
     */
    private $count;

    public function testBatch()
    {
        $count = (int)(new SelectQuery($this->connection))
            ->select(new Expression('count(*)'))
            ->from('Album')
            ->fetch()
            ->scalar();

        $cursor = (new SelectQuery($this->connection))
            ->from('Album')
            ->fetch()
            ->batchCursor()
            ->setBatchSize(10)
            ->setBatchHandler([$this, 'handleBatch']);

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
        $count = (int)(new SelectQuery($this->connection))
            ->select(new Expression('count(*)'))
            ->from('Album')
            ->fetch()
            ->scalar();

        $this->count = 0;

        $cursor = (new SelectQuery($this->connection))
            ->from('Album')
            ->fetch()
            ->batchCursor()
            ->setBatchSize(10)
            ->setRowHandler([$this, 'handleRow']);
        
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
