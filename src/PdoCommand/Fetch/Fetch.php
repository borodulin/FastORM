<?php

declare(strict_types=1);

namespace Borodulin\ORM\PdoCommand\Fetch;

use Borodulin\ORM\PdoCommand\StatementInterface;
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
     *
     * @param StatementInterface $statement Prepared statement
     */
    public function __construct(StatementInterface $statement)
    {
        $this->statement = $statement;
    }

    public function one(iterable $params = []): array
    {
        $pdoStatement = $this->statement->execute($params);
        $result = $pdoStatement->fetch($this->fetchStyle);
        $pdoStatement->closeCursor();

        return \is_array($result) ? $result : [];
    }

    public function all(iterable $params = []): array
    {
        $pdoStatement = $this->statement->execute($params);
        $result = $pdoStatement->fetchAll($this->fetchStyle);
        $pdoStatement->closeCursor();

        return \is_array($result) ? $result : [];
    }

    public function column(int $columnNumber = 0, iterable $params = []): array
    {
        $pdoStatement = $this->statement->execute($params);
        $result = $pdoStatement->fetchAll(PDO::FETCH_COLUMN, $columnNumber);

        return \is_array($result) ? $result : [];
    }

    /**
     * Executes the SQL statement and returns the value of the first column in the first row of data.
     * This method is best used when only a single value is needed for a query.
     *
     * @param array $params
     *
     * @return string|false|null the value of the first column in the first row of the query result.
     *                           False is returned if there is no value.
     */
    public function scalar(int $columnNumber = 0, iterable $params = [])
    {
        $pdoStatement = $this->statement->execute($params);
        $result = $pdoStatement->fetchColumn($columnNumber);
        if (\is_resource($result) && 'stream' === get_resource_type($result)) {
            return stream_get_contents($result);
        }
        $pdoStatement->closeCursor();

        return $result;
    }

    public function exists(iterable $params = []): bool
    {
        return (bool) $this->scalar(0, $params);
    }

    /**
     * Fetch a two-column result into an array where the first column is a key and the second column is the value.
     *
     * @param array $params
     */
    public function map(iterable $params = []): array
    {
        $pdoStatement = $this->statement->execute($params);
        $result = $pdoStatement->fetchAll(PDO::FETCH_KEY_PAIR);

        return \is_array($result) ? $result : [];
    }

    /**
     * Fetch rows indexed by first column.
     *
     * @param array $params
     *
     * @see PDO::FETCH_UNIQUE
     */
    public function indexed(iterable $params = []): array
    {
        $pdoStatement = $this->statement->execute($params);
        $result = $pdoStatement->fetchAll(PDO::FETCH_UNIQUE);

        return \is_array($result) ? $result : [];
    }

    /**
     * Fetch rows grouped by first column values.
     *
     * @param array $params
     *
     * @see PDO::FETCH_GROUP
     */
    public function grouped(iterable $params = []): array
    {
        $pdoStatement = $this->statement->execute($params);
        $result = $pdoStatement->fetchAll(PDO::FETCH_GROUP);

        return \is_array($result) ? $result : [];
    }

    /**
     * Iterates over database cursor.
     */
    public function cursor(iterable $params = [], int $limit = null): \Traversable
    {
        $pdoStatement = $this->statement->execute($params);

        return (new Cursor($pdoStatement, $this->fetchStyle))
            ->setLimit($limit);
    }

    /**
     * Returns iterable batch array of rows.
     */
    public function batchCursor(iterable $params = [], int $batchSize = 25, int $limit = null): \Traversable
    {
        $pdoStatement = $this->statement->execute($params);

        return (new BatchCursor($pdoStatement, $this->fetchStyle))
            ->setBatchSize($batchSize)
            ->setLimit($limit);
    }
}
