<?php

declare(strict_types=1);

namespace FastOrm\SQL\Operator;

use FastOrm\SQL\QueryInterface;

class ExistsOperator implements OperatorInterface
{

    /**
     * @var QueryInterface
     */
    private $query;

    public function __construct(QueryInterface $query)
    {
        $this->query = $query;
    }
}
