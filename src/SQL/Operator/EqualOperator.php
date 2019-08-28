<?php

declare(strict_types=1);

namespace FastOrm\SQL\Operator;

class EqualOperator implements OperatorInterface
{
    private $column;
    private $value;

    public function __construct($column, $value)
    {
        $this->column = $column;
        $this->value = $value;
    }
}
