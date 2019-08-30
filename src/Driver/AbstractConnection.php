<?php

declare(strict_types=1);

namespace FastOrm\Driver;

use FastOrm\ConnectionInterface;
use FastOrm\Event\ConnectionEvent;
use FastOrm\NotSupportedException;
use FastOrm\SQL\BuilderFactory;
use FastOrm\SQL\BuilderFactoryInterface;
use FastOrm\SQL\ExpressionInterface;
use FastOrm\Transaction;
use PDO;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractConnection implements ConnectionInterface
{

    /**
     * @var Transaction
     */
    protected $transaction;
    /**
     * @var EventDispatcherInterface|null
     */
    protected $eventDispatcher;
    /**
     * @var LoggerInterface|null
     */
    protected $logger;
    /**
     * @var PDO
     */
    protected $pdo;
    protected $dsn;
    protected $username;
    protected $password;
    /**
     * @var array
     */
    protected $options;
    /**
     * @var BuilderFactory
     */
    private $builderFactory;

    /**
     * AbstractConnection constructor.
     * @param $dsn
     * @param $username
     * @param $password
     * @param array $options
     * @param BuilderFactoryInterface|null $builderFactory
     */
    public function __construct(
        string $dsn,
        string $username = null,
        string $password = null,
        array $options = [],
        BuilderFactoryInterface $builderFactory = null
    ) {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->options = $options;
        if ($builderFactory === null) {
            $this->builderFactory = new BuilderFactory($this);
        }
    }

    public function getPDO(): PDO
    {
        if ($this->pdo === null) {
            $this->pdo = $this->createPdoInstance();
            $this->eventDispatcher && $this->eventDispatcher
                ->dispatch(new ConnectionEvent($this, ConnectionEvent::EVENT_AFTER_OPEN));
        }
        return $this->pdo;
    }

    public function getIsActive(): bool
    {
        return $this->pdo !== null;
    }

    public function close(): void
    {
        $this->pdo = null;
        $this->eventDispatcher && $this->eventDispatcher
            ->dispatch(new ConnectionEvent($this, ConnectionEvent::EVENT_AFTER_CLOSE));
    }

    public function setEventDispatcher(?EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Sets the isolation level of the current transaction.
     * @param string $isolationLevel The transaction isolation level to use for this transaction.
     * This can be one of
     * @see TransactionInterface::READ_UNCOMMITTED
     * @see TransactionInterface::READ_COMMITTED
     * @see TransactionInterface::REPEATABLE_READ
     * @see TransactionInterface::SERIALIZABLE
     * @see http://en.wikipedia.org/wiki/Isolation_%28database_systems%29#Isolation_levels
     */
    public function setTransactionIsolationLevel(string $isolationLevel)
    {
        $this->pdoExec("SET TRANSACTION ISOLATION LEVEL $isolationLevel");
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

    /**
     * @param $sql
     * @return int
     */
    protected function pdoExec($sql)
    {
        return $this->getPDO()->exec($sql);
    }

    protected function createPdoInstance(): PDO
    {
        $this->options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        return new PDO($this->dsn, $this->username, $this->password, $this->options);
    }

    public function setCharset($charset)
    {
        $this->pdoExec('SET NAMES ' . $this->pdo->quote($charset));
    }

    public function getBuilderFactory(): BuilderFactoryInterface
    {
        return $this->builderFactory;
    }

    public function buildExpression(ExpressionInterface $expression): string
    {
        return $this->builderFactory->build($expression)->getText();
    }
}
