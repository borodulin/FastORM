<?php

declare(strict_types=1);

namespace FastOrm\Tests;

use FastOrm\ConnectionInterface;

class TestConnectionFactory
{
    private function getTestDriverMap()
    {
        return [
            'sqlite' => [],
        ];
    }

    public function create(): ConnectionInterface
    {
        $driver = getenv('dsn', 'sqlite::memory:');
    }
}
