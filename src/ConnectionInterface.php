<?php

declare(strict_types=true);

namespace FastOrm;

use FastOrm\Schema\SchemaInterface;
use PDO;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

interface ConnectionInterface extends LoggerAwareInterface
{
    public function getSchema(): SchemaInterface;

    public function getPDO(): PDO;

    public function getIsActive(): bool;

    public function open(): void;

    public function close(): void;

    public function getLogger(): ?LoggerInterface;

    public function setEventDispatcher(?EventDispatcherInterface $eventDispatcher): void;

    public function getEventDispatcher(): ?EventDispatcherInterface;

    public function beginTransaction(): Transaction;
}
