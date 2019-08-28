<?php

declare(strict_types=1);

namespace FastOrm\SQL\Operator;

class CompareOperator implements OperatorInterface
{

    private $column;
    private $operator;
    private $value;

    public function __construct($column, $operator, $value)
    {

        $this->column = $column;
        $this->operator = $operator;
        $this->value = $value;
    }
}
