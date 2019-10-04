<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\SQL\Clause\SelectQuery;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class ImmutableTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     */
    public function testSelect()
    {
        $db = $this->createConnection();
        $query1 = (new SelectQuery($db))
            ->from('albums')->select('AlbumId');
        $query2 = clone $query1;
        $countAll1 = count($query1);
        $countAll2 = (int)$query2->select('count(1)')->fetch()->scalar();
        $this->assertEquals($countAll1, $countAll2);
        $count = count($query1->limit(100));
        $this->assertEquals(100, $count);
    }
}
