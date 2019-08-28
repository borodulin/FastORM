<?php

declare(strict_types=1);

namespace FastOrm\Driver;

use Exception;
use FastOrm\Fetch\Fetch;
use FastOrm\Fetch\FetchInterface;
use PDO;
use PDOException;
use PDOStatement;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class Command implements CommandInterface, LoggerAwareInterface
{
    /**
     * @var PDO
     */
    private $pdo;
    /**
     * @var LoggerInterface
     */
    private $logger;

    private $params;
    private $sql;

    public function __construct(PDO $pdo, string $sql, array $params = [])
    {
        $this->pdo = $pdo;
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
            $this->logger && $this->logger->debug('Statement prepared');
        } catch (Exception $e) {
            $message = $e->getMessage() . "\nFailed to prepare SQL: $this->sql";
            $errorInfo = $e instanceof PDOException ? $e->errorInfo : null;
            throw new DbException($message, $errorInfo, (int) $e->getCode(), $e);
        }
        return $pdoStatement;
    }

    public function bindValue($name, $value, int $dataType = null): self
    {
        if ($dataType === null) {
            $dataType = $this->getPdoType($value);
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
                $type = $this->getPdoType($value);
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
     * @param array $params
     * @return bool
     * @throws DbException
     */
    public function execute(array $params = []): bool
    {
        if ($this->sql == '') {
            return false;
        }
        $pdoStatement = $this->getPdoStatement();

        try {
            return $pdoStatement->execute();
        } catch (Exception $e) {
            // TODO log & handle
//            $e = $this->schema->convertException($e, $rawSql);
        }
        return false;
    }

    /**
     * @param array $params
     * @return FetchInterface
     * @throws DbException
     */
    public function fetch(array $params = []): FetchInterface
    {
        return new Fetch($this->bindValues($params));
    }

    protected function getPdoType($data)
    {
        static $typeMap = [
            // php type => PDO type
            'boolean' => PDO::PARAM_BOOL,
            'integer' => PDO::PARAM_INT,
            'string' => PDO::PARAM_STR,
            'resource' => PDO::PARAM_LOB,
            'NULL' => PDO::PARAM_NULL,
        ];
        $type = gettype($data);
        return isset($typeMap[$type]) ?? PDO::PARAM_STR;
    }
}
