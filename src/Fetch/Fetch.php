<?php

declare(strict_types=1);

namespace FastOrm\Fetch;

use FastOrm\Schema\Command;
use FastOrm\Schema\DbException;

class Fetch implements FetchInterface
{

    /**
     * @var Command
     */
    private $command;

    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    private $indexBy;

    public function one(): object
    {
        // TODO: Implement one() method.
    }

    public function column(): array
    {
        // TODO: Implement column() method.
    }

    /**
     * Executes the SQL statement and returns the value of the first column in the first row of data.
     * This method is best used when only a single value is needed for a query.
     * @return string|null|false the value of the first column in the first row of the query result.
     * False is returned if there is no value.
     * @throws DbException
     */
    public function scalar()
    {
        $pdoStatement = $this->command->getPdoStatement();
        $result = $pdoStatement->fetchColumn();
        if (is_resource($result) && get_resource_type($result) === 'stream') {
            return stream_get_contents($result);
        }
        return $result;
    }

    public function exists(): bool
    {
        // TODO: Implement exists() method.
    }


    public function indexBy($column): FetchAllInterface
    {
        $this->indexBy = $column;
        return $this;
    }

    public function all(): array
    {
        // TODO: Implement all() method.
    }

    public function batch(int $batchSize = 100): BatchInterface
    {
        // TODO: Implement batch() method.
    }


}
