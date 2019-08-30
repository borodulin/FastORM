<?php

declare(strict_types=1);

namespace FastOrm\SQL\Clause;


use FastOrm\SQL\QueryInterface;

abstract class AbstractClause implements ClauseInterface
{

    /**
     * @var QueryInterface
     */
    protected $query;

    public function __construct(QueryInterface $query)
    {
        $this->query = $query;
    }

    public function getQuery(): QueryInterface
    {
        return $this->query;
    }
}
