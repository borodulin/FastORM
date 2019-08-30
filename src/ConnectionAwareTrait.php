<?php

declare(strict_types=1);

namespace FastOrm;

trait ConnectionAwareTrait
{
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    public function setConnection(ConnectionInterface $connection): void
    {
        $this->connection = $connection;
    }
}
