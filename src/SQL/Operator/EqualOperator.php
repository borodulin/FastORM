<?php

declare(strict_types=true);

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
