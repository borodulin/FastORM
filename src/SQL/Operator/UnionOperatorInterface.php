<?php

declare(strict_types=1);

namespace FastOrm\SQL\Operator;

use FastOrm\SQL\QueryInterface;

interface UnionOperatorInterface
{
    public function union(QueryInterface $query): QueryInterface;

    public function unionAll(QueryInterface $query): QueryInterface;
}
