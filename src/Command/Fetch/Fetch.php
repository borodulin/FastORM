<?php

declare(strict_types=1);

namespace FastOrm\Command\Fetch;

use PDO;
use PDOStatement;

class Fetch implements FetchInterface
{
    /**
     * @var PDOStatement
     */
    private $pdoStatement;

    private $fetchStyle = PDO::FETCH_ASSOC;

    /**
     * Fetch constructor.
     * @param PDOStatement $pdoStatement
     */
    public function __construct(PDOStatement $pdoStatement)
    {
        $this->pdoStatement = $pdoStatement;
    }

    private $indexBy;

    /**
     * @return object
     */
    public function one(): object
    {
        if ($this->pdoStatement->execute()) {
            $result = $this->pdoStatement->fetch($this->fetchStyle);
            $this->pdoStatement->closeCursor();
            return $result;
        }
        return null;
    }

    /**
     * @param int $columnNumber
     * @return array
     */
    public function column(int $columnNumber = 0): array
    {
        if ($this->pdoStatement->execute()) {
            $result = $this->pdoStatement->fetchAll(PDO::FETCH_COLUMN, $columnNumber);
            if (is_array($result)) {
                return $result;
            }
        }
        return [];
    }

    /**
     * Executes the SQL statement and returns the value of the first column in the first row of data.
     * This method is best used when only a single value is needed for a query.
     * @param int $columnNumber
     * @return string|null|false the value of the first column in the first row of the query result.
     * False is returned if there is no value.
     */
    public function scalar(int $columnNumber = 0)
    {
        $result = $this->pdoStatement->fetchColumn($columnNumber);
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
        if ($this->pdoStatement->execute()) {
            if ($this->indexBy) {
                $result = [];
                while ($row = $this->pdoStatement->fetch($this->fetchStyle)) {
                    $result[$row[$this->indexBy]] = $row;
                }
            } else {
                $result = $this->pdoStatement->fetchAll($this->fetchStyle);
            }
            if (is_array($result)) {
                return $result;
            }
        }
        return [];
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
