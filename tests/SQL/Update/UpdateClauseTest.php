<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Update;

use FastOrm\SQL\Clause\UpdateQuery;
use FastOrm\Tests\TransactionTestCase;

class UpdateClauseTest extends TransactionTestCase
{
    public function testUpdate(): void
    {
        $count = (new UpdateQuery($this->db))
            ->update('Artist')
            ->set(['Name' => 'Dummy'])
            ->where()->equal('ArtistId', 1)
            ->execute();
        $this->assertEquals(1, $count);
    }
}
