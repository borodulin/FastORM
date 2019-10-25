<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Update;

use FastOrm\SQL\Clause\UpdateQuery;
use FastOrm\Tests\TestCase;

class UpdateClauseTest extends TestCase
{
    public function testUpdate()
    {
        $tran = $this->db->beginTransaction();
        $count = (new UpdateQuery($this->db))
            ->update('Artist')
            ->set(['Name' => 'Dummy'])
            ->where()->equal('ArtistId', 1)
            ->execute();
        $this->assertEquals(1, $count);
        $tran->rollBack();
    }
}
