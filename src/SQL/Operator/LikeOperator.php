<?php

declare(strict_types=true);

namespace FastOrm\SQL\Operator;

class LikeOperator implements OperatorInterface
{
    private $column;
    private $value;

    public function __construct($column, $value)
    {
        $this->column = $column;
        $this->value = $value;
    }
}
