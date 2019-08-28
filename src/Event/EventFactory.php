<?php

declare(strict_types=1);

namespace FastOrm\Event;

use FastOrm\ConnectionInterface;
use FastOrm\Transaction;

class EventFactory
{
    private static $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance(): EventFactory
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function beginTransaction(Transaction $transaction)
    {
        return new TransactionEvent($transaction, TransactionEvent::EVENT_BEGIN);
    }

    public function commitTransaction(Transaction $transaction)
    {
        return new TransactionEvent($transaction, TransactionEvent::EVENT_COMMIT);
    }

    public function rollbackTransaction(Transaction $transaction)
    {
        return new TransactionEvent($transaction, TransactionEvent::EVENT_ROLLBACK);
    }

    public function openConnection(ConnectionInterface $connection)
    {
        return new ConnectionEvent($connection, ConnectionEvent::EVENT_OPEN);
    }
}
