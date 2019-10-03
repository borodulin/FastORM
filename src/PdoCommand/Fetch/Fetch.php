<?php

declare(strict_types=1);

namespace FastOrm\PdoCommand\Fetch;

use FastOrm\PdoCommand\StatementInterface;
use PDO;

class Fetch implements FetchInterface
{

    private $fetchStyle = PDO::FETCH_ASSOC;
    /**
     * @var StatementInterface
     */
    private $statement;

    /**
     * Fetch constructor.
     * @param StatementInterface $statement Prepared statement
     */
    public function __construct(StatementInterface $statement)
    {
        $this->statement = $statement;
    }

    private $indexBy;

    /**
     * @param array $params
     * @return array
     */
    public function one(iterable $params = []): array
    {
        $pdoStatement =  $this->statement->execute($params);
        $result = $pdoStatement->fetch($this->fetchStyle);
        $pdoStatement->closeCursor();
        return is_array($result) ? $result : [];
    }

    /**
     * @param int $columnNumber
     * @param array $params
     * @return array
     */
    public function column(int $columnNumber = 0, iterable $params = []): array
    {
        $pdoStatement =  $this->statement->execute($params);
        $result = $pdoStatement->fetchAll(PDO::FETCH_COLUMN, $columnNumber);
        return is_array($result) ? $result : [];
    }

    /**
     * Executes the SQL statement and returns the value of the first column in the first row of data.
     * This method is best used when only a single value is needed for a query.
     * @param int $columnNumber
     * @param array $params
     * @return string|null|false the value of the first column in the first row of the query result.
     * False is returned if there is no value.
     */
    public function scalar(int $columnNumber = 0, iterable $params = [])
    {
        $pdoStatement =  $this->statement->execute($params);
        $result = $pdoStatement->fetchColumn($columnNumber);
        if (is_resource($result) && get_resource_type($result) === 'stream') {
            return stream_get_contents($result);
        }
        $pdoStatement->closeCursor();
        return $result;
    }

    /**
     * @param array $params
     * @return bool
     */
    public function exists(iterable $params = []): bool
    {
        return (bool) $this->scalar(0, $params);
    }


    public function indexBy($column): FetchAllInterface
    {
        $this->indexBy = $column;
        return $this;
    }

    /**
     * @param array $params
     * @return array
     */
    public function all(iterable $params = []): array
    {
        $pdoStatement =  $this->statement->execute($params);
        if ($this->indexBy) {
            $result = [];
            while ($row = $pdoStatement->fetch($this->fetchStyle)) {
                $result[$row[$this->indexBy]] = $row;
            }
        } else {
            $result = $pdoStatement->fetchAll($this->fetchStyle);
        }
        return is_array($result) ? $result : [];
    }


    /**
     * Fetch a two-column result into an array where the first column is a key and the second column is the value.
     * @param array $params
     * @return array
     */
    public function map(iterable $params = []): array
    {
        $pdoStatement =  $this->statement->execute($params);
        $result = $pdoStatement->fetchAll(PDO::FETCH_KEY_PAIR);
        return is_array($result) ? $result : [];
    }

    /**
     * Fetch rows indexed by first column
     * @param array $params
     * @return array
     * @see PDO::FETCH_UNIQUE
     */
    public function indexed(iterable $params = []): array
    {
        $pdoStatement =  $this->statement->execute($params);
        $result = $pdoStatement->fetchAll(PDO::FETCH_UNIQUE);
        return is_array($result) ? $result : [];
    }

    /**
     * Fetch rows grouped by first column values
     * @param array $params
     * @return array
     * @see PDO::FETCH_GROUP
     */
    public function grouped(iterable $params = []): array
    {
        $pdoStatement =  $this->statement->execute($params);
        $result = $pdoStatement->fetchAll(PDO::FETCH_GROUP);
        return is_array($result) ? $result : [];
    }

    /**
     * @param array $params
     * @return CursorInterface
     */
    public function cursor(iterable $params = []): CursorInterface
    {
        $pdoStatement =  $this->statement->execute($params);
        return new Cursor($pdoStatement, $this->fetchStyle);
    }

    /**
     * @param array $params
     * @return BatchCursorInterface
     */
    public function batchCursor(iterable $params = []): BatchCursorInterface
    {
        $pdoStatement =  $this->statement->execute($params);
        return new BatchCursor($pdoStatement, $this->fetchStyle);
    }
}
