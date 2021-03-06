<?php

declare(strict_types=1);

namespace Borodulin\ORM;

use Borodulin\ORM\Driver\DriverInterface;
use PDO;
use Psr\Log\LoggerAwareInterface;

interface ConnectionInterface extends LoggerAwareInterface, EventDispatcherAwareInterface
{
    /**
     * Starts a transaction.
     *
     * @return Transaction the transaction initiated
     * @See TransactionInterface::begin() for details.
     */
    public function beginTransaction(string $isolationLevel = null): Transaction;

    public function getDriver(): DriverInterface;

    public function getPdo(): PDO;

    public function getIsActive(): bool;

    /**
     * Sets the isolation level of the current transaction.
     *
     * @see Transaction::READ_UNCOMMITTED
     * @see Transaction::READ_COMMITTED
     * @see Transaction::REPEATABLE_READ
     * @see Transaction::SERIALIZABLE
     * @see http://en.wikipedia.org/wiki/Isolation_%28database_systems%29#Isolation_levels
     */
    public function setTransactionIsolationLevel(string $isolationLevel);
}
