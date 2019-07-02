<?php

declare(strict_types=true);

namespace FastOrm\SQL\Operator;

class BetweenOperator implements OperatorInterface
{
    private $column;
    private $intervalStart;
    private $intervalEnd;

    public function __construct($column, $intervalStart, $intervalEnd)
    {
        $this->column = $column;
        $this->intervalStart = $intervalStart;
        $this->intervalEnd = $intervalEnd;
    }
}
