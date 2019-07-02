<?php

declare(strict_types=true);

namespace FastOrm\Schema;

use FastOrm\ConnectionInterface;
use PDO;
use PDOStatement;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class Command implements LoggerAwareInterface
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
    protected function prepare()
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

    /**
     * Executes the SQL statement and returns the value of the first column in the first row of data.
     * This method is best used when only a single value is needed for a query.
     * @return string|null|false the value of the first column in the first row of the query result.
     * False is returned if there is no value.
     * @throws DbException
     */
    public function queryScalar()
    {
        $pdoStatement = $this->prepare();
        $result = $pdoStatement->fetchColumn();
        if (is_resource($result) && get_resource_type($result) === 'stream') {
            return stream_get_contents($result);
        }
        return $result;
    }
}
