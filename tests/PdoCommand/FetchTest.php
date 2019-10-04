<?php

declare(strict_types=1);

namespace FastOrm\Tests\PdoCommand;

use FastOrm\NotSupportedException;
use FastOrm\SQL\QueryBuilder;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class FetchTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     */
    public function testIndexed()
    {
        $db = $this->createConnection();
        $all = (new QueryBuilder($db))->select()
            ->from('albums')
            ->limit(10)
            ->fetch()
            ->indexed();
        $this->assertCount(10, $all);
        $this->assertArrayNotHasKey('AlbumId', $all[1]);
    }

    /**
     * @throws NotSupportedException
     */
    public function testGrouped()
    {
        $db = $this->createConnection();
        $all = (new QueryBuilder($db))->select()
            ->from('albums')
            ->limit(10)
            ->fetch()
            ->grouped();
        $this->assertCount(10, $all);
        $this->assertArrayNotHasKey('AlbumId', $all[1]);
    }

    /**
     * @throws NotSupportedException
     */
    public function testBatchCursor()
    {
        $db = $this->createConnection();
        $cursor = (new QueryBuilder($db))->select()
            ->from('albums')
            ->fetch()
            ->batchCursor()
            ->setLimit(10);
        $this->assertCount(10, iterator_to_array($cursor));
    }
}
