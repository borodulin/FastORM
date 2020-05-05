<?php

declare(strict_types=1);

namespace Borodulin\ORM\Tests\SQL\Select;

use Borodulin\ORM\SQL\Clause\SelectQuery;
use Borodulin\ORM\SQL\Expression;
use Borodulin\ORM\Tests\TestCase;

class FetchTest extends TestCase
{
    public function testColumn(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->select([
                'id' => 'TrackId',
            ])
            ->from('Track t')
            ->limit(10)
            ->fetch();
        $rows = $fetch->column();
        $this->assertCount(10, $rows);
    }

    public function testMap(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->select([
                'id' => 'TrackId',
                'TrackId',
            ])
            ->from('Track t')
            ->orderBy('TrackId desc')
            ->limit(10)
            ->fetch();
        $rows = $fetch->map();
        $flip = array_flip($rows);
        $this->assertTrue($rows == $flip);
    }

    public function testExists(): void
    {
        $fetch = (new SelectQuery($this->db))
            ->select(new Expression('1'))
            ->fetch();
        $exists = $fetch->exists();
        $this->assertEquals($exists, true);
        $fetch = (new SelectQuery($this->db))
            ->select(new Expression('0'))
            ->fetch();
        $exists = $fetch->exists();
        $this->assertEquals($exists, false);
    }
}
