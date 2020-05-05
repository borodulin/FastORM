<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Update;

use Borodulin\ORM\SQL\Clause\UpdateQuery;
use Borodulin\ORM\Tests\TransactionTestCase;

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
