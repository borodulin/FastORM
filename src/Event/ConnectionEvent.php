<?php

declare(strict_types=1);

namespace FastOrm\Event;

use FastOrm\ConnectionInterface;

class ConnectionEvent
{
    const EVENT_AFTER_OPEN = 'afterOpen';

    /**
     * @var ConnectionInterface
     */
    private $connection;
    /**
     * @var string
     */
    private $event;

    public function __construct(ConnectionInterface $connection, string $event)
    {
        $this->connection = $connection;
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }
}
