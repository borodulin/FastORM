<?php

declare(strict_types=1);

namespace FastOrm\Fetch;

use FastOrm\Schema\Command;
use FastOrm\Schema\DbException;
use PDOStatement;

class Fetch implements FetchInterface
{

    /**
     * @var Command
     */
    private $command;
    /**
     * @var PDOStatement
     */
    private $pdoStatement;

    /**
     * Fetch constructor.
     * @param Command $command
     * @throws DbException
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
        $this->pdoStatement = $this->command->getPdoStatement();
    }

    private $indexBy;

    /**
     * @return object
     */
    public function one(): object
    {
        $result = $this->pdoStatement->fetch();
        $this->pdoStatement->closeCursor();
        return $result;
    }

    /**
     * @return array
     */
    public function column(): array
    {
        $result = $this->pdoStatement->fetchColumn();
        $this->pdoStatement->closeCursor();
        return $result;
    }

    /**
     * Executes the SQL statement and returns the value of the first column in the first row of data.
     * This method is best used when only a single value is needed for a query.
     * @return string|null|false the value of the first column in the first row of the query result.
     * False is returned if there is no value.
     */
    public function scalar()
    {
        $result = $this->pdoStatement->fetchColumn();
        if (is_resource($result) && get_resource_type($result) === 'stream') {
            return stream_get_contents($result);
        }
        $this->pdoStatement->closeCursor();
        return $result;
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return (bool) $this->scalar();
    }


    public function indexBy($column): FetchAllInterface
    {
        $this->indexBy = $column;
        return $this;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        $result = $this->pdoStatement->fetchColumn();
        $this->pdoStatement->closeCursor();
        return $result;
    }

    public function batch(int $batchSize = 100): BatchInterface
    {
        return new Batch();
    }

    public function cancel()
    {
        $this->pdoStatement = null;
    }
}
