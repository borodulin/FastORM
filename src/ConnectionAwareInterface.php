<?php

declare(strict_types=1);

namespace FastOrm;

interface ConnectionAwareInterface
{
    public function setConnection(ConnectionInterface $connection): void;
}
