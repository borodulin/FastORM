<?php

declare(strict_types=1);

namespace FastOrm\SQL\SearchCondition\Operator;

use FastOrm\SQL\BuilderInterface;

class CompareOperator implements OperatorInterface, BuilderInterface
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

    public function getText(): string
    {
        return "$this->column $this->operator $this->value";
    }
}
