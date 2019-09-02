<?php

declare(strict_types=1);

namespace FastOrm\Driver;

use Exception;
use FastOrm\Fetch\Fetch;
use FastOrm\Fetch\FetchInterface;
use FastOrm\SQL\CommandInterface;
use PDO;
use PDOException;
use PDOStatement;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class Command implements CommandInterface, LoggerAwareInterface
{
    const PARAM_PREFIX = 'p';
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
    private $counter = 0;

    public function __construct(PDO $pdo, string $sql = '', array $params = [])
    {
        $this->pdo = $pdo;
        $this->sql = $sql;
        $this->params = $params;
    }

    /**
     * @return PDOStatement
     * @throws DbException
     */
    public function getPdoStatement(): PDOStatement
    {
        try {
            $pdoStatement = $this->pdo->prepare($this->sql);
            if ($pdoStatement === false) {
                throw new DbException("Failed to prepare SQL: $this->sql", null);
            }
            /** @var PdoValue $value */
            foreach ($this->params as $name => $value) {
                $pdoStatement->bindValue($name, $value->getValue(), $value->getType());
            }
            $this->logger && $this->logger->debug('Statement prepared');
        } catch (Exception $e) {
            $message = $e->getMessage() . "\nFailed to prepare SQL: $this->sql";
            $errorInfo = $e instanceof PDOException ? $e->errorInfo : null;
            throw new DbException($message, $errorInfo, (int) $e->getCode(), $e);
        }
        return $pdoStatement;
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
        $this->bindParams($params);

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
        $this->bindParams($params);
        return new Fetch($this->getPdoStatement());
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
        return $typeMap[$type] ?? PDO::PARAM_STR;
    }

    public function bindParams(array $params): CommandInterface
    {
        foreach ($params as $name => $value) {
            if ($value instanceof PdoValue) {
                $this->params[$name] = $value;
            } else {
                $type = $this->getPdoType($value);
                $this->params[$name] = new PdoValue($value, $type);
            }
        }
        return $this;
    }


    public function bindValue($value, string &$paramName = null): CommandInterface
    {
        if (is_string($value) && (preg_match('/^[@:](.+)$/', $value, $matches))) {
            $paramName = $matches[1];
            $value = null;
        } else {
            $paramName = self::PARAM_PREFIX . ++$this->counter;
        }
        $this->bindParam($paramName, $value);
        return $this;
    }

    public function bindParam($name, $value, int $dataType = null): CommandInterface
    {
        if ($dataType === null) {
            $dataType = $this->getPdoType($value);
        }
        $this->params[$name] = new PdoValue($value, $dataType);
        return $this;
    }

    /**
     * @return string
     */
    public function getSql(): string
    {
        return $this->sql;
    }

    /**
     * @param string $sql
     */
    public function setSql(string $sql): void
    {
        $this->sql = $sql;
    }
}
