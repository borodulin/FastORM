<?php

declare(strict_types=1);

namespace FastOrm;

use FastOrm\Event\EventFactory;
use FastOrm\Schema\SavepointInterface;

class Transaction
{
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
    /**
     * @var EventFactory
     */
    private $eventFactory;

    public function __construct(
        ConnectionInterface $connection,
        EventFactory $eventFactory
    ) {
        $this->connection = $connection;
        $this->eventFactory = $eventFactory;
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
     * @throws NotSupportedException
     */
    public function begin(string $isolationLevel = null)
    {
        $this->connection->open();

        $logger = $this->connection->getLogger();
        $eventDispatcher = $this->connection->getEventDispatcher();
        $schema = $this->connection->getSchema();

        if ($this->level === 0) {
            if ($isolationLevel !== null) {
                $schema->setTransactionIsolationLevel($isolationLevel);
            }

            $logger && $logger->debug(
                'Begin transaction' . ($isolationLevel ? ' with isolation level ' . $isolationLevel : '')
            );

            if ($eventDispatcher) {
                $eventDispatcher->dispatch($this->eventFactory->beginTransaction($this));
            }
            $this->connection->getPDO()->beginTransaction();
            $this->level = 1;

            return;
        }

        if ($schema instanceof SavepointInterface) {
            $logger && $logger->debug('Set savepoint ' . $this->level);
            $schema->createSavepoint('LEVEL' . $this->level);
        } else {
            $logger && $logger->info('Transaction not started: nested transaction not supported');
            throw new NotSupportedException('Transaction not started: nested transaction not supported.');
        }
        $this->level++;
    }

    /**
     * Commits a transaction.
     * @throws Exception if the transaction is not active
     */
    public function commit(): void
    {
        if (!$this->getIsActive()) {
            throw new Exception('Failed to commit transaction: transaction was inactive.');
        }
        $logger = $this->connection->getLogger();
        $schema = $this->connection->getSchema();
        $this->level--;
        if ($this->level === 0) {
            $logger && $logger->debug('Commit transaction');
            $this->connection->getPDO()->commit();
            $this->connection->getEventDispatcher()->dispatch($this->eventFactory->commitTransaction($this));
            return;
        }

        if ($schema instanceof SavepointInterface) {
            $logger && $logger->debug('Release savepoint ' . $this->level);
            $schema->releaseSavepoint('LEVEL' . $this->level);
        } else {
            $logger && $logger->info('Transaction not committed: nested transaction not supported');
        }
    }

    /**
     * Rolls back a transaction.
     */
    public function rollBack(): void
    {
        if (!$this->getIsActive()) {
            // do nothing if transaction is not active: this could be the transaction is committed
            // but the event handler to "commitTransaction" throw an exception
            return;
        }

        $logger = $this->connection->getLogger();

        $this->level--;
        if ($this->level === 0) {
            $logger && $logger->debug('Roll back transaction');
            $this->connection->getPDO()->rollBack();
            $this->connection->getEventDispatcher()->dispatch($this->eventFactory->rollbackTransaction($this));
            return;
        }

        $schema = $this->connection->getSchema();
        if ($schema instanceof SavepointInterface) {
            $logger && $logger->debug('Roll back to savepoint ' . $this->level);
            $schema->rollBackSavepoint('LEVEL' . $this->level);
        } else {
            $logger && $logger->info('Transaction not rolled back: nested transaction not supported');
        }
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
     * @throws Exception if the transaction is not active
     * @see http://en.wikipedia.org/wiki/Isolation_%28database_systems%29#Isolation_levels
     */
    public function setIsolationLevel(string $level)
    {
        if (!$this->getIsActive()) {
            throw new Exception('Failed to set isolation level: transaction was inactive.');
        }
        $logger = $this->connection->getLogger();
        $logger && $logger->debug('Setting transaction isolation level to ' . $level);
        $this->connection->getSchema()->setTransactionIsolationLevel($level);
    }

    /**
     * @return int The current nesting level of the transaction.
     */
    public function getLevel(): int
    {
        return $this->level;
    }
}
