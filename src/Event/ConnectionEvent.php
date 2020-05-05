<?php

declare(strict_types=1);

namespace Borodulin\ORM\Event;

use Borodulin\ORM\ConnectionInterface;

class ConnectionEvent
{
    public const EVENT_AFTER_OPEN = 'afterOpen';

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

    public function getEvent(): string
    {
        return $this->event;
    }
}
