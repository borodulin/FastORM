<?php

declare(strict_types=1);

namespace FastOrm\Command;

use PDO;
use PDOException;
use PDOStatement;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class StatementFactory implements LoggerAwareInterface
{
    use LoggerAwareTrait;
    /**
     * @var PDO
     */
    private $pdo;
    /**
     * @var string
     */
    private $sql;
    /**
     * @var Params
     */
    private $params;

    public function __construct(PDO $pdo, string $sql, Params $params = null)
    {
        $this->pdo = $pdo;
        $this->sql = $sql;
        $this->params = $params ?? new Params();
    }

    /**
     * @param array $params
     * @param array $options
     * @return bool|PDOStatement
     * @throws DbException
     */
    public function execute(array $params = [], array $options = [])
    {
        try {
            $pdoStatement = $this->pdo->prepare($this->sql, $options);
            if ($pdoStatement === false) {
                throw new DbException("Failed to prepare SQL: $this->sql", null);
            }
            $this->params->bindAll($params);
            /** @var PdoValue $value */
            foreach ($this->params->getParams() as $name => $value) {
                $pdoStatement->bindValue($name, $value->getValue(), $value->getType());
            }
            if (!$pdoStatement->execute()) {
                throw new DbException("Failed to execute SQL: $this->sql");
            }
            $this->logger && $this->logger->debug('Statement prepared');
        } catch (PDOException $e) {
            $message = $e->getMessage() . "\nFailed to prepare SQL: $this->sql";
            throw new DbException($message, $e->errorInfo, (int) $e->getCode(), $e);
        }
        return $pdoStatement;
    }

    /**
     * @return Params
     */
    public function getParams(): Params
    {
        return $this->params;
    }
}
