<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\SQL\QueryBuilder;
use FastOrm\Tests\TestCase;

class FetchTest extends TestCase
{
    public function testIndexed(): void
    {
        $all = (new QueryBuilder($this->db))
            ->select(['Title', 'AlbumId'])
            ->from('Album')
            ->limit(10)
            ->fetch()
            ->indexed();
        $this->assertCount(10, $all);
        foreach (array_keys($all) as $key) {
            $this->assertIsString($key);
        }
        $this->assertArrayNotHasKey('Title', array_shift($all));
    }

    public function testGrouped(): void
    {
        $all = (new QueryBuilder($this->db))
            ->select(['Title', 'AlbumId'])
            ->from('Album')
            ->limit(10)
            ->fetch()
            ->grouped()
        ;
        $this->assertCount(10, $all);
        foreach (array_keys($all) as $key) {
            $this->assertIsString($key);
        }
        $this->assertArrayNotHasKey('Title', array_shift($all));
    }

    public function testBatchCursor(): void
    {
        $cursor = (new QueryBuilder($this->db))
            ->select()
            ->from('Album')
            ->fetch()
            ->batchCursor([], 25, 10)
        ;
        foreach ($cursor as $batch) {
            $this->assertCount(10, $batch);
        }
    }
}
