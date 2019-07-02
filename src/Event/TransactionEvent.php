<?php

declare(strict_types=true);

namespace FastOrm\Event;

use FastOrm\Transaction;

class TransactionEvent
{
    const EVENT_BEGIN = 'begin';
    const EVENT_COMMIT = 'commit';
    const EVENT_ROLLBACK = 'rollback';


    /**
     * @var Transaction
     */
    private $transaction;

    private $event;

    public function __construct(Transaction $transaction, string $event)
    {
        $this->transaction = $transaction;
        $this->event = $event;
    }

    public function getEvent(): string
    {
        return $this->event;
    }
}
