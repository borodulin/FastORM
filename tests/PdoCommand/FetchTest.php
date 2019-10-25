<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\SQL\QueryBuilder;
use FastOrm\Tests\TestCase;

class FetchTest extends TestCase
{
    public function testIndexed()
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

    public function testGrouped()
    {
        $all = (new QueryBuilder($this->db))
            ->select(['Title', 'AlbumId'])
            ->from('Album')
            ->limit(10)
            ->fetch()
            ->grouped();
        $this->assertCount(10, $all);
        foreach (array_keys($all) as $key) {
            $this->assertIsString($key);
        }
        $this->assertArrayNotHasKey('Title', array_shift($all));
    }

    public function testBatchCursor()
    {
        $cursor = (new QueryBuilder($this->db))
            ->select()
            ->from('Album')
            ->fetch()
            ->batchCursor()
            ->setLimit(10);
        $this->assertCount(10, iterator_to_array($cursor));
    }
}
