<?php

declare(strict_types=1);

namespace FastOrm;

use FastOrm\Driver\SavepointInterface;
use FastOrm\Event\TransactionEvent;
use Psr\Log\LoggerAwareTrait;

class Transaction implements EventDispatcherAwareInterface
{
    use EventDispatcherAwareTrait, LoggerAwareTrait;

    /**
     * A constant representing the transaction isolation level `READ UNCOMMITTED`.
     * @see http://en.wikipedia.org/wiki/Isolation_%28database_systems%29#Isolation_levels
     */
    const READ_UNCOMMITTED = 'READ UNCOMMITTED';
    /**
     * A constant representing the transaction isolation level `READ COMMITTED`.
     * @see http://en.wikipedia.org/wiki/Isolation_%28database_systems%29#Isolation_levels
     */
    const READ_COMMITTED = 'READ COMMITTED';
    /**
     * A constant representing the transaction isolation level `REPEATABLE READ`.
     * @see http://en.wikipedia.org/wiki/Isolation_%28database_systems%29#Isolation_levels
     */
    const REPEATABLE_READ = 'REPEATABLE READ';
    /**
     * A constant representing the transaction isolation level `SERIALIZABLE`.
     * @see http://en.wikipedia.org/wiki/Isolation_%28database_systems%29#Isolation_levels
     */
    const SERIALIZABLE = 'SERIALIZABLE';


    /**
     * @var int the nesting level of the transaction. 0 means the outermost level.
     */
    private $level = 0;
    /**
     * @var ConnectionInterface
     */
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }


    /**
     * Returns a value indicating whether this transaction is active.
     * @return bool whether this transaction is active. Only an active transaction
     * can [[commit()]] or [[rollBack()]].
     */
    public function getIsActive(): bool
    {
        return $this->level > 0 && $this->connection->getIsActive();
    }

    /**
     * Begins a transaction.
     * @param string|null $isolationLevel The [isolation level][] to use for this transaction.
     * This can be one of [[READ_UNCOMMITTED]], [[READ_COMMITTED]], [[REPEATABLE_READ]] and [[SERIALIZABLE]] but
     * also a string containing DBMS specific syntax to be used after `SET TRANSACTION ISOLATION LEVEL`.
     * If not specified (`null`) the isolation level will not be set explicitly and the DBMS default will be used.
     *
     * > Note: This setting does not work for PostgreSQL, where setting the isolation level before the transaction
     * has no effect. You have to call [[setIsolationLevel()]] in this case after the transaction has started.
     *
     * > Note: Some DBMS allow setting of the isolation level only for the whole connection so subsequent transactions
     * may get the same isolation level even if you did not specify any. When using this feature
     * you may need to set the isolation level for all transactions explicitly to avoid conflicting settings.
     * At the time of this writing affected DBMS are MSSQL and SQLite.
     *
     * [isolation level]: http://en.wikipedia.org/wiki/Isolation_%28database_systems%29#Isolation_levels
     * @return Transaction
     * @throws NotSupportedException
     */
    public function begin(string $isolationLevel = null): Transaction
    {
        $pdo = $this->connection->getPdo();

        if ($this->level === 0) {
            if ($isolationLevel !== null) {
                $this->connection->setTransactionIsolationLevel($isolationLevel);
            }

            $this->logger && $this->logger->debug(
                'Begin transaction' . ($isolationLevel ? ' with isolation level ' . $isolationLevel : '')
            );
            $this->eventDispatcher && $this->eventDispatcher
                ->dispatch(new TransactionEvent($this, TransactionEvent::EVENT_BEGIN));
            $pdo->beginTransaction();
            $this->level = 1;

            return $this;
        }

        $driver = $this->connection->getDriver();
        if ($driver instanceof SavepointInterface) {
            $this->logger && $this->logger
                ->debug('Set savepoint ' . $this->level);
            $driver->createSavepoint($pdo, 'LEVEL' . $this->level);
        } else {
            $this->logger && $this->logger
                ->info('Transaction not started: nested transaction not supported');
            throw new NotSupportedException('Transaction not started: nested transaction not supported.');
        }
        $this->level++;
        return $this;
    }

    /**
     * Commits a transaction.
     * @throws Exception if the transaction is not active
     */
    public function commit(): Transaction
    {
        if (!$this->getIsActive()) {
            throw new Exception('Failed to commit transaction: transaction was inactive.');
        }
        $pdo = $this->connection->getPdo();
        $this->level--;
        if ($this->level === 0) {
            $this->logger && $this->logger
                ->debug('Commit transaction');
            $pdo->commit();
            $this->eventDispatcher && $this->eventDispatcher
                ->dispatch(new TransactionEvent($this, TransactionEvent::EVENT_COMMIT));
            return $this;
        }

        $driver = $this->connection->getDriver();
        if ($driver instanceof SavepointInterface) {
            $this->logger && $this->logger
                ->debug('Release savepoint ' . $this->level);
            $driver->releaseSavepoint($pdo, 'LEVEL' . $this->level);
        } else {
            $this->logger && $this->logger
                ->info('Transaction not committed: nested transaction not supported');
        }
        return $this;
    }

    /**
     * Rolls back a transaction.
     */
    public function rollBack(): Transaction
    {
        if (!$this->getIsActive()) {
            // do nothing if transaction is not active: this could be the transaction is committed
            // but the event handler to "commitTransaction" throw an exception
            return $this;
        }
        $pdo = $this->connection->getPdo();
        $this->level--;
        if ($this->level === 0) {
            $this->logger && $this->logger
                ->debug('Roll back transaction');
            $pdo->rollBack();
            $this->eventDispatcher && $this->eventDispatcher
                ->dispatch(new TransactionEvent($this, TransactionEvent::EVENT_ROLLBACK));
            return $this;
        }
        $driver = $this->connection->getDriver();
        if ($driver instanceof SavepointInterface) {
            $this->logger && $this->logger
                ->debug('Roll back to savepoint ' . $this->level);
            $driver->rollBackSavepoint($pdo, 'LEVEL' . $this->level);
        } else {
            $this->logger && $this->logger
                ->info('Transaction not rolled back: nested transaction not supported');
        }
        return $this;
    }

    /**
     * Sets the transaction isolation level for this transaction.
     *
     * This method can be used to set the isolation level while the transaction is already active.
     * However this is not supported by all DBMS so you might rather specify the isolation level directly
     * when calling [[begin()]].
     * @param string $level The transaction isolation level to use for this transaction.
     * This can be one of [[READ_UNCOMMITTED]], [[READ_COMMITTED]], [[REPEATABLE_READ]] and [[SERIALIZABLE]] but
     * also a string containing DBMS specific syntax to be used after `SET TRANSACTION ISOLATION LEVEL`.
     * @return Transaction
     * @throws Exception if the transaction is not active
     * @see http://en.wikipedia.org/wiki/Isolation_%28database_systems%29#Isolation_levels
     */
    public function setIsolationLevel(string $level): Transaction
    {
        if (!$this->getIsActive()) {
            throw new Exception('Failed to set isolation level: transaction was inactive.');
        }
        $this->logger && $this->logger
            ->debug('Setting transaction isolation level to ' . $level);
        $this->connection->setTransactionIsolationLevel($level);
        return $this;
    }

    /**
     * @return int The current nesting level of the transaction.
     */
    public function getLevel(): int
    {
        return $this->level;
    }
}
