<?php

declare(strict_types=1);

namespace FastOrm\Fetch;

use PDO;
use PDOStatement;

class Fetch implements FetchInterface
{
    /**
     * @var PDOStatement
     */
    private $pdoStatement;

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
        $result = $this->pdoStatement->fetch();
        $this->pdoStatement->closeCursor();
        return $result;
    }

    /**
     * @return array
     */
    public function column(): array
    {
        $this->pdoStatement->execute();
//        $result = call_user_func_array([$this->pdoStatement, 'fetchColumn'], (array) PDO::FETCH_ASSOC);
        $result = $this->pdoStatement->fetchAll(PDO::FETCH_COLUMN);
        $this->pdoStatement->closeCursor();
        if ($result === false) {
            return [];
        }
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
        if ($this->pdoStatement->execute()) {
            $result = $this->pdoStatement->fetchAll();
        } else {
            $result = [];
        }
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
