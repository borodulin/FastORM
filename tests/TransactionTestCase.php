<?php

declare(strict_types=1);

namespace FastOrm\Tests;

use FastOrm\Transaction;

class TransactionTestCase extends TestCase
{
    /**
     * @var Transaction
     */
    protected $transaction;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transaction = $this->db->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->transaction->rollBack();
    }
}
