<?php

declare(strict_types=1);

namespace FastOrm;

use FastOrm\Driver\DriverFactory;
use FastOrm\Driver\DriverInterface;
use FastOrm\Event\ConnectionEvent;
use PDO;
use Psr\Log\LoggerAwareTrait;

class Connection implements ConnectionInterface
{
    use LoggerAwareTrait;
    use EventDispatcherAwareTrait;

    /**
     * @var Transaction
     */
    private $transaction;
    /**
     * @var string
     */
    private $dsn;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;
    /**
     * @var array
     */
    private $options;
    /**
     * @var DriverInterface
     */
    private $driver;
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * Connection constructor.
     * @param string $dsn
     * @param string|null $username
     * @param string|null $password
     * @param array $options
     * @throws NotSupportedException
     */
    public function __construct(string $dsn, string $username = null, string $password = null, array $options = [])
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->options = $options;
        $this->driver = (new DriverFactory())($dsn);
    }

    /**
     * Sets the isolation level of the current transaction.
     * @param string $isolationLevel
     * @see Transaction::READ_UNCOMMITTED
     * @see Transaction::READ_COMMITTED
     * @see Transaction::REPEATABLE_READ
     * @see Transaction::SERIALIZABLE
     * @see http://en.wikipedia.org/wiki/Isolation_%28database_systems%29#Isolation_levels
     */
    public function setTransactionIsolationLevel(string $isolationLevel)
    {
        $this->driver->setTransactionIsolationLevel($this->getPdo(), $isolationLevel);
    }

    /**
     * Starts a transaction.
     * @param string|null $isolationLevel
     * @return Transaction the transaction initiated
     * @throws NotSupportedException
     * @See Transaction::begin() for details.
     */
    public function beginTransaction(string $isolationLevel = null): Transaction
    {
        if ($this->transaction === null) {
            $this->transaction = new Transaction($this);
            $this->logger && $this->transaction->setLogger($this->logger);
            $this->eventDispatcher && $this->transaction->setEventDispatcher($this->eventDispatcher);
        }
        return $this->transaction->begin($isolationLevel);
    }

    public function getDriver(): DriverInterface
    {
        return $this->driver;
    }

    public function getPdo(): PDO
    {
        if ($this->pdo === null) {
            $this->pdo = $this->driver->createPdoInstance(
                $this->dsn,
                $this->username,
                $this->password,
                $this->options
            );
            $this->eventDispatcher && $this->eventDispatcher
                ->dispatch(new ConnectionEvent($this, ConnectionEvent::EVENT_AFTER_OPEN));
        }
        return $this->pdo;
    }

    public function getIsActive(): bool
    {
        return $this->pdo !== null;
    }
}
