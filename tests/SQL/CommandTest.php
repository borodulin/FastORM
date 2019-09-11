<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\Command\Command;
use FastOrm\Command\DbException;
use FastOrm\NotSupportedException;
use FastOrm\Tests\TestConnectionTrait;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     */
    public function testErrorPrepare()
    {
        $connection = $this->createConnection();
        $command = new Command($connection->getPdo(), 'select * from bad_table_name');
        $this->expectException(DbException::class);
        $command->fetch()->all();
    }

    /**
     * @throws NotSupportedException
     */
    public function testErrorExecute()
    {
        $connection = $this->createConnection();
        $command = new Command($connection->getPdo(), 'select * from albums where AlbumId=:p12');
        $this->expectException(DbException::class);
        $cursor = $command->fetch(['p12' => false])->cursor()->scrollable();
        $rows = [];
        foreach ($cursor as $value) {
            $rows[] = $value;
        }
    }
}
