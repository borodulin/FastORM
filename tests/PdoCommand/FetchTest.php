<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\SQL\QueryBuilder;
use FastOrm\Tests\TestCase;

class FetchTest extends TestCase
{
    public function testIndexed()
    {
        $all = (new QueryBuilder($this->connection))->select()
            ->from('Album')
            ->limit(10)
            ->fetch()
            ->indexed();
        $this->assertCount(10, $all);
        $this->assertArrayNotHasKey('AlbumId', $all[1]);
    }

    public function testGrouped()
    {
        $all = (new QueryBuilder($this->connection))
            ->select()
            ->from('Album')
            ->limit(10)
            ->fetch()
            ->grouped();
        $this->assertCount(10, $all);
        $this->assertArrayNotHasKey('AlbumId', $all[1]);
    }

    public function testBatchCursor()
    {
        $cursor = (new QueryBuilder($this->connection))
            ->select()
            ->from('Album')
            ->fetch()
            ->batchCursor()
            ->setLimit(10);
        $this->assertCount(10, iterator_to_array($cursor));
    }
}
