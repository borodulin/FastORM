<?php

declare(strict_types=1);

namespace FastOrm\Command\Fetch;

interface FetchInterface extends FetchIndexedInterface
{
    public function one(): object;

    public function column(int $columnNumber = 0): array;

    public function exists(): bool;

    /**
     * Executes the SQL statement and returns the value of the first column in the first row of data.
     * This method is best used when only a single value is needed for a query.
     * @param int $columnNumber
     * @return string|null|false the value of the first column in the first row of the query result.
     * False is returned if there is no value.
     */
    public function scalar(int $columnNumber = 0);

    public function cancel();

    public function batch(int $batchSize = 100): BatchInterface;
}