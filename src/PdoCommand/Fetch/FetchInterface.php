<?php

declare(strict_types=1);

namespace FastOrm\PdoCommand\Fetch;

interface FetchInterface extends FetchIndexedInterface
{
    /**
     * @param array $params
     * @return array
     */
    public function one(array $params = []): array;

    /**
     * @param int $columnNumber
     * @param array $params
     * @return array
     */
    public function column(int $columnNumber = 0, array $params = []): array;

    /**
     * @param array $params
     * @return bool
     */
    public function exists(array $params = []): bool;

    /**
     * Executes the SQL statement and returns the value of the first column in the first row of data.
     * This method is best used when only a single value is needed for a query.
     * @param int $columnNumber
     * @param array $params
     * @return string|null|false the value of the first column in the first row of the query result.
     * False is returned if there is no value.
     */
    public function scalar(int $columnNumber = 0, array $params = []);

    /**
     * Fetch a two-column result into an array where the first column is a key and the second column is the value.
     * @param array $params
     * @return array
     */
    public function map(array $params = []): array;

    /**
     * Fetch rows indexed by first column
     * @param array $params
     * @return array
     * @see PDO::FETCH_UNIQUE
     */
    public function indexed(array $params = []): array;

    /**
     * Fetch rows grouped by first column values
     * @param array $params
     * @return array
     * @see PDO::FETCH_GROUP
     */
    public function grouped(array $params = []): array;


    /**
     * @param array $params
     * @return CursorInterface
     */
    public function cursor(array $params = []): CursorInterface;

    /**
     * @param array $params
     * @return BatchCursorInterface
     */
    public function batchCursor(array $params = []): BatchCursorInterface;
}
