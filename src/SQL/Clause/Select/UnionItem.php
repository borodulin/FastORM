<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause\Select;

use FastOrm\SQL\Clause\SelectClauseInterface;

class UnionItem
{
    /**
     * @var SelectDistinctInterface
     */
    private $query;
    /**
     * @var bool
     */
    private $all;

    public function __construct(SelectClauseInterface $query, bool $all)
    {
        $this->query = $query;
        $this->all = $all;
    }

    /**
     * @return SelectDistinctInterface
     */
    public function getQuery(): SelectClauseInterface
    {
        return $this->query;
    }

    public function isAll(): bool
    {
        return $this->all;
    }
}
