<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

class SelectClause implements ClauseInterface
{
    use ClauseTrait;

    /**
     * @var bool
     */
    private $distinct = false;
    private $columns = [];

    public function addColumns($columns): void
    {
        $this->columns = $columns;
    }

    public function distinct(): void
    {
        $this->distinct = true;
    }
}
