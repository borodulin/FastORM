<?php

declare(strict_types=1);

namespace FastOrm\Command\Fetch;

use FastOrm\Command\DbException;
use FastOrm\Command\StatementFactory;
use PDO;

class Fetch implements FetchInterface
{
    /**
     * @var StatementFactory
     */
    private $statementFactory;

    private $fetchStyle = PDO::FETCH_ASSOC;

    /**
     * Fetch constructor.
     * @param StatementFactory $statementFactory
     */
    public function __construct(StatementFactory $statementFactory)
    {
        $this->statementFactory = $statementFactory;
    }

    private $indexBy;

    /**
     * @return array
     * @throws DbException
     */
    public function one(): array
    {
        $statement = $this->statementFactory->execute();
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
        $statement = $this->statementFactory->execute();
        $result = $statement->fetchAll(PDO::FETCH_COLUMN, $columnNumber);
        return is_array($result) ? $result : [];
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
        $statement = $this->statementFactory->execute();
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
        $statement = $this->statementFactory->execute();
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

    public function cursor(): CursorInterface
    {
        return new Cursor($this->statementFactory);
    }

    /**
     * Fetch a two-column result into an array where the first column is a key and the second column is the value.
     * @return array
     * @throws DbException
     */
    public function map(): array
    {
        $statement = $this->statementFactory->execute();
        return $statement->fetchAll(PDO::FETCH_KEY_PAIR);
    }
}
