<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL\Delete;

use FastOrm\SQL\Clause\DeleteQuery;
use FastOrm\Tests\TestCase;

class DeleteClauseTest extends TestCase
{
    public function testDelete()
    {
        (new DeleteQuery($this->connection))
            ->from('Album')
            ->where()->equal('AlbumId', 1);
        $this->assertTrue(true);
    }
}
