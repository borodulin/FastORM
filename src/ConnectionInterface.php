<?php

declare(strict_types=1);

namespace FastOrm;

use FastOrm\Driver\DriverInterface;
use PDO;
use Psr\Log\LoggerAwareInterface;

interface ConnectionInterface extends LoggerAwareInterface, EventDispatcherAwareInterface
{
    /**
     * Sets the isolation level of the current transaction.
     * @param string $isolationLevel
     * @see TransactionInterface::READ_UNCOMMITTED
     * @see TransactionInterface::READ_COMMITTED
     * @see TransactionInterface::REPEATABLE_READ
     * @see TransactionInterface::SERIALIZABLE
     * @see http://en.wikipedia.org/wiki/Isolation_%28database_systems%29#Isolation_levels
     */
    public function setTransactionIsolationLevel(string $isolationLevel);

    /**
     * Starts a transaction.
     * @param string|null $isolationLevel
     * @return Transaction the transaction initiated
     * @See TransactionInterface::begin() for details.
     */
    public function beginTransaction(string $isolationLevel = null): Transaction;

    public function getDriver(): DriverInterface;

    public function getPdo(): PDO;

    public function getIsActive(): bool;
}
