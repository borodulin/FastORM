<?php

declare(strict_types=true);

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
