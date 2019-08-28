<?php

declare(strict_types=1);

namespace FastOrm;

use FastOrm\Event\EventFactory;
use FastOrm\Schema\SchemaInterface;
use PDO;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

class Connection implements ConnectionInterface
{

    /**
     * @var SchemaInterface
     */
    private $schema;
    private $transaction;
    /**
     * @var EventDispatcherInterface|null
     */
    private $eventDispatcher;
    private $logger;

    public function __construct(SchemaInterface $schema)
    {
        $this->schema = $schema;
    }

    public function getSchema(): SchemaInterface
    {
        return $this->schema;
    }

    public function getPDO(): PDO
    {
        return $this->schema->getPDO();
    }

    public function getIsActive(): bool
    {
        return false;
    }

    public function open(): void
    {
        // TODO: Implement open() method.
    }

    public function close(): void
    {
        // TODO: Implement close() method.
    }

    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    public function setEventDispatcher(?EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getEventDispatcher(): ?EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }

    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function beginTransaction(): Transaction
    {
        if ($this->transaction === null) {
            $this->transaction = new Transaction($this, EventFactory::getInstance());
        }
        return $this->transaction;
    }
}
