<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;

use FastOrm\SQL\QueryInterface;

class UnionItem
{
    /**
     * @var QueryInterface
     */
    private $query;
    /**
     * @var bool
     */
    private $all;

    public function __construct(QueryInterface $query, bool $all)
    {
        $this->query = $query;
        $this->all = $all;
    }

    /**
     * @return QueryInterface
     */
    public function getQuery(): QueryInterface
    {
        return $this->query;
    }

    /**
     * @return bool
     */
    public function isAll(): bool
    {
        return $this->all;
    }
}
