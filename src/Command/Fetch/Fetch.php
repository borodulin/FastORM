<?php

declare(strict_types=1);

namespace FastOrm\Command\Fetch;

use FastOrm\Command\Command;
use FastOrm\Command\DbException;
use PDO;

class Fetch implements FetchInterface
{
    /**
     * @var Command
     */
    private $command;

    private $fetchStyle = PDO::FETCH_ASSOC;

    /**
     * Fetch constructor.
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    private $indexBy;

    /**
     * @return object
     * @throws DbException
     */
    public function one(): object
    {
        $statement = $this->command->executeStatement();
        $result = $statement->fetch($this->fetchStyle);
        $statement->closeCursor();
        return $result;
    }

    /**
     * @param int $columnNumber
     * @return array
     * @throws DbException
     */
    public function column(int $columnNumber = 0): array
    {
        $statement = $this->command->executeStatement();
        $result = $statement->fetchAll(PDO::FETCH_COLUMN, $columnNumber);
        if (is_array($result)) {
            return $result;
        }
        return [];
    }

    /**
     * Executes the SQL statement and returns the value of the first column in the first row of data.
     * This method is best used when only a single value is needed for a query.
     * @param int $columnNumber
     * @return string|null|false the value of the first column in the first row of the query result.
     * False is returned if there is no value.
     * @throws DbException
     */
    public function scalar(int $columnNumber = 0)
    {
        $statement = $this->command->executeStatement();
        $result = $statement->fetchColumn($columnNumber);
        if (is_resource($result) && get_resource_type($result) === 'stream') {
            return stream_get_contents($result);
        }
        $statement->closeCursor();
        return $result;
    }

    /**
     * @return bool
     * @throws DbException
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
     * @throws DbException
     */
    public function all(): array
    {
        $statement = $this->command->executeStatement();
        if ($this->indexBy) {
            $result = [];
            while ($row = $statement->fetch($this->fetchStyle)) {
                $result[$row[$this->indexBy]] = $row;
            }
        } else {
            $result = $statement->fetchAll($this->fetchStyle);
        }
        return is_array($result) ? $result : [];
    }

    public function cancel()
    {
        $this->command = null;
    }

    public function cursor(): CursorInterface
    {
        return new Cursor($this->command);
    }
}
