<?php

declare(strict_types=1);

namespace FastOrm\SQL\Operator;

use FastOrm\SQL\QueryInterface;

class UnionOperator
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
}
