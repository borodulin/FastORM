<?php

declare(strict_types=true);

namespace FastOrm\Event;

use FastOrm\ConnectionInterface;

class ConnectionEvent
{
    const EVENT_OPEN = 'open';

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
