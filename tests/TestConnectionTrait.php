<?php

declare(strict_types=1);

namespace FastOrm\Tests;


use FastOrm\Connection;
use FastOrm\NotSupportedException;

trait TestConnectionTrait
{
    /**
     * @throws NotSupportedException
     */
    private function createConnection()
    {
        $db = __DIR__ . '/db/chinook.db';
        return new Connection('sqlite:' . $db);
    }
}
