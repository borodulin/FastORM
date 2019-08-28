<?php

declare(strict_types=1);

namespace FastOrm\Schema;

use FastOrm\ConnectionInterface;
use FastOrm\Fetch\Fetch;
use FastOrm\Fetch\FetchInterface;
use PDO;
use PDOStatement;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class Command implements CommandExecuteInterface, CommandFetchInterface, LoggerAwareInterface
{
    /**
     * @var ConnectionInterface
     */
    private $connection;
    /**
     * @var PDO
     */
    private $pdo;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var SchemaInterface
     */
    private $schema;

    private $params;
    private $sql;

    public function __construct(ConnectionInterface $connection, $sql, $params)
    {
        $this->connection = $connection;
        $this->schema = $connection->getSchema();
        $this->pdo = $connection->getPDO();
        $this->sql = $sql;
        $this->params = $params;
    }

    /**
     * @return PDOStatement
     * @throws DbException
     */
    public function getPdoStatement()
    {
        try {
            $pdoStatement = $this->pdo->prepare($this->sql);
            /** @var PdoValue $value */
            foreach ($this->params as $name => $value) {
                $pdoStatement->bindValue($name, $value->getValue(), $value->getType());
            }
            $this->params = [];
            if ($pdoStatement === false) {
                throw new DbException("Failed to prepare SQL: $this->sql", null);
            }
//            $this->bindParams();
            $this->logger && $this->logger->debug('Statement prepared');
        } catch (\Exception $e) {
            $message = $e->getMessage() . "\nFailed to prepare SQL: $this->sql";
            $errorInfo = $e instanceof \PDOException ? $e->errorInfo : null;
            throw new DbException($message, $errorInfo, (int) $e->getCode(), $e);
        }
        return $pdoStatement;
    }

    public function bindValue($name, $value, int $dataType = null): self
    {
        if ($dataType === null) {
            $dataType = $this->schema->getPdoType($value);
        }
        $this->params[$name] = new PdoValue($value, $dataType);
        return $this;
    }

    public function bindValues(array $values): self
    {
        foreach ($values as $name => $value) {
            if ($value instanceof PdoValue) {
                $this->params[$name] = $value;
            } else {
                $type = $this->schema->getPdoType($value);
                $this->params[$name] = new PdoValue($value, $type);
            }
        }
        return $this;
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

    public function execute(array $params = []): bool
    {
        // TODO: Implement execute() method.
    }

    public function fetch(array $params = []): FetchInterface
    {
        return new Fetch($this->bindValues($params));
    }
}
