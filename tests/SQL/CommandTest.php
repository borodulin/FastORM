<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\PdoCommand\DbException;
use FastOrm\PdoCommand\Fetch\Fetch;
use FastOrm\PdoCommand\Statement;
use FastOrm\Tests\TestCase;
use PDO;

class CommandTest extends TestCase
{

    /**
     * @throws DbException
     */
    public function testErrorPrepare()
    {
        $command = new Statement($this->connection->getPdo(), 'select * from bad_table_name');
        $this->expectException(DbException::class);
        $command->execute();
    }

    public function testErrorExecute()
    {
        $statement = new Statement(
            $this->connection->getPdo(),
            'select * from Album where AlbumId=:p12',
            [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]
        );
        $this->expectException(DbException::class);
        $cursor = (new Fetch($statement))->cursor(['p12' => false]);
        $rows = [];
        foreach ($cursor as $value) {
            $rows[] = $value;
        }
    }
}
