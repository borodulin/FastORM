<?php

declare(strict_types=1);

namespace FastOrm\Driver;

trait DriverAwareTrait
{
    /**
     * @var DriverInterface
     */
    protected $driver;

    public function setDriver(DriverInterface $driver): void
    {
        $this->driver = $driver;
    }
}
