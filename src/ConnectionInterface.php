<?php

declare(strict_types=1);

namespace FastOrm;

use FastOrm\SQL\Builder\ClauseBuilderFactoryInterface;
use FastOrm\SQL\Expression\ExpressionBuilderFactoryInterface;
use PDO;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerAwareInterface;

interface ConnectionInterface extends LoggerAwareInterface
{
    /**
     * Sets the isolation level of the current transaction.
     * @param string $isolationIsolationLevel
     * @see TransactionInterface::READ_UNCOMMITTED
     * @see TransactionInterface::READ_COMMITTED
     * @see TransactionInterface::REPEATABLE_READ
     * @see TransactionInterface::SERIALIZABLE
     * @see http://en.wikipedia.org/wiki/Isolation_%28database_systems%29#Isolation_levels
     */
    public function setTransactionIsolationLevel(string $isolationIsolationLevel);

    /**
     * Starts a transaction.
     * @param string|null $isolationLevel
     * @return Transaction the transaction initiated
     * @See TransactionInterface::begin() for details.
     */
    public function beginTransaction(string $isolationLevel = null): Transaction;

    public function getPDO(): PDO;

    public function getIsActive(): bool;

    public function close(): void;

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void;

    public function createClauseBuilderFactory(): ClauseBuilderFactoryInterface;

    public function createExpressionBuilderFactory(): ExpressionBuilderFactoryInterface;
}
