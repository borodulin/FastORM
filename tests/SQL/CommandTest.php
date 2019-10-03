<?php

declare(strict_types=1);

namespace FastOrm\Tests\SQL;

use FastOrm\NotSupportedException;
use FastOrm\PdoCommand\DbException;
use FastOrm\PdoCommand\Fetch\Fetch;
use FastOrm\PdoCommand\Statement;
use FastOrm\Tests\TestConnectionTrait;
use PDO;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    use TestConnectionTrait;

    /**
     * @throws NotSupportedException
     * @throws DbException
     */
    public function testErrorPrepare()
    {
        $connection = $this->createConnection();
        $command = new Statement($connection->getPdo(), 'select * from bad_table_name');
        $this->expectException(DbException::class);
        $command->execute();
    }

    /**
     * @throws NotSupportedException
     * @throws DbException
     */
    public function testErrorExecute()
    {
        $connection = $this->createConnection();
        $statement = new Statement(
            $connection->getPdo(),
            'select * from albums where AlbumId=:p12',
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
