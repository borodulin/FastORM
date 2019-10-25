<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Update;

use FastOrm\SQL\Clause\UpdateQuery;
use FastOrm\Tests\TestCase;

class UpdateClauseTest extends TestCase
{
    public function testUpdate()
    {
        $tran = $this->connection->beginTransaction();
        $count = (new UpdateQuery($this->connection))
            ->update('Artist')
            ->set(['Name' => 'Dummy'])
            ->where()->equal('ArtistId', 1)
            ->execute();
        $this->assertEquals(1, $count);
        $tran->rollBack();
    }
}
