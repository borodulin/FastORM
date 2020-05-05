<?php

declare(strict_types=1);

namespace Borodulin\ORM\PdoCommand\Fetch;

interface FetchInterface
{
    public function one(iterable $params = []): array;

    public function all(iterable $params = []): array;

    public function column(int $columnNumber = 0, iterable $params = []): array;

    public function exists(iterable $params = []): bool;

    /**
     * Executes the SQL statement and returns the value of the first column in the first row of data.
     * This method is best used when only a single value is needed for a query.
     *
     * @return string|false|null the value of the first column in the first row of the query result.
     *                           False is returned if there is no value.
     */
    public function scalar(int $columnNumber = 0, iterable $params = []);

    /**
     * Fetch a two-column result into an array where the first column is a key and the second column is the value.
     */
    public function map(iterable $params = []): array;

    /**
     * Fetch rows indexed by first column.
     *
     * @see PDO::FETCH_UNIQUE
     */
    public function indexed(iterable $params = []): array;

    /**
     * Fetch rows grouped by first column values.
     *
     * @see PDO::FETCH_GROUP
     */
    public function grouped(iterable $params = []): array;

    /**
     * Iterates over database cursor.
     */
    public function cursor(iterable $params = [], int $limit = null): \Traversable;

    /**
     * Returns iterable batch array of rows.
     */
    public function batchCursor(iterable $params = [], int $batchSize = 25, int $limit = null): \Traversable;
}
