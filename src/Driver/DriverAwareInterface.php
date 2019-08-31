<?php

declare(strict_types=1);

namespace FastOrm\Driver;

interface DriverAwareInterface
{
    public function setDriver(DriverInterface $driver): void;
}
