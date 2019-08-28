<?php

declare(strict_types=1);

namespace FastOrm\Fetch;

use FastOrm\Schema\DbException;

interface FetchInterface extends FetchIndexedInterface
{
    public function one(): object;

    public function column(): array;

    public function exists(): bool;

    /**
     * Executes the SQL statement and returns the value of the first column in the first row of data.
     * This method is best used when only a single value is needed for a query.
     * @return string|null|false the value of the first column in the first row of the query result.
     * False is returned if there is no value.
     * @throws DbException
     */
    public function scalar();
}
