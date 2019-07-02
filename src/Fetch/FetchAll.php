<?php

declare(strict_types=true);

namespace FastOrm\Fetch;

class FetchAll implements FetchAllInterface, IndexByInterface
{
    private $indexByColumn;

    public function all(): array
    {
        // TODO: Implement all() method.
    }

    public function indexBy($column): FetchAllInterface
    {
        $this->indexByColumn = $column;
        return $this;
    }
}
