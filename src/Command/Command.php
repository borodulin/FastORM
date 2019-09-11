<?php

declare(strict_types=1);

namespace FastOrm\Command;

use FastOrm\Command\Fetch\Fetch;
use FastOrm\Command\Fetch\FetchInterface;
use PDO;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class Command implements CommandInterface, LoggerAwareInterface
{
    /**
     * @var StatementFactory
     */
    private $statementFactory;

    public function __construct(PDO $pdo, string $sql = '', Params $params = null)
    {
        $this->statementFactory = new StatementFactory($pdo, $sql, $params);
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
        $this->statementFactory->setLogger($logger);
    }

    /**
     * @param array $params
     * @return int
     * @throws DbException
     */
    public function execute(array $params = []): int
    {
        $statement = $this->statementFactory->execute($params);
        return $statement->rowCount();
    }
    /**
     * @param array $params
     * @return FetchInterface
     */
    public function fetch(array $params = []): FetchInterface
    {
        $this->statementFactory->getParams()->bindAll($params);
        return new Fetch($this->statementFactory);
    }
}
