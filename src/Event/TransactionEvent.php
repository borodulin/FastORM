<?php

declare(strict_types=1);

namespace FastOrm\Event;

use FastOrm\Transaction;

class TransactionEvent
{
    public const EVENT_BEGIN = 'begin';
    public const EVENT_COMMIT = 'commit';
    public const EVENT_ROLLBACK = 'rollback';


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
