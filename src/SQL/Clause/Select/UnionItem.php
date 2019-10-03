<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\SelectInterface;

class UnionItem
{
    /**
     * @var SelectInterface
     */
    private $query;
    /**
     * @var bool
     */
    private $all;

    public function __construct(SelectInterface $query, bool $all)
    {
        $this->query = $query;
        $this->all = $all;
    }

    /**
     * @return SelectInterface
     */
    public function getQuery(): SelectInterface
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
